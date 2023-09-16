<?php

namespace App\Jobs;

use App\Models\AssetLabel;
use App\Models\Earning;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ParseReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Report
     */
    private $report;

    /**
     * @var int
     */
    private $line;

    /**
     * @var \Illuminate\Config\Repository
     */
    private $reportType;
    /**
     * @var array
     */
    private $revenue;
    private $assetLabelsColumn;
    private $revenueColumn;
    /**
     * @var string
     */
    private $path;

    /**
     * Create a new job instance.
     *
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
        $this->reportType = config("reports.{$report->type}");

        $this->revenue = [];

        $this->line = 0;
        $this->revenueColumn = null;
        $this->assetLabelsColumn = null;

        $this->path = storage_path("app/{$this->report->file_path}");
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->report->status != 'new') {
            throw new \InvalidArgumentException('Report does not have the status NEW. Aborting');
        }

        $this->markAsInProgress();

        $this->run();

        $this->insertRevenue();
        $this->markFinished();
    }


    /**
     * @param $headers
     * @throws \Exception
     */
    private function determineColumnNumbers($headers)
    {
        foreach ($headers as $key => $column) {
            if ($column == $this->reportType['asset_labels']) {
                $this->assetLabelsColumn = $key;
            }

            if ($column == $this->reportType['revenue']) {
                $this->revenueColumn = $key;
            }
        }

        if ($this->checkIfColumnMissing()) {
            throw new \Exception("Invalid report type.");
        }
    }

    /**
     * @throws \Exception
     */
    private function run()
    {
        $handle = fopen($this->path, "r");

        while (!feof($handle)) {
            $this->line++;

            $line = trim(fgets($handle));
            if (empty($line)) continue; // Skipping empty lines.

            if (!$this->skippedLinesIgnored()) {
                echo 'hangt';
                continue;
            }

            $row = str_getcsv($line);

            if ($this->checkIfColumnMissing()) {
                $this->determineColumnNumbers($row);
                continue;
            }

            $assetLabels = $row[$this->assetLabelsColumn];
            $revenue = (float)$row[$this->revenueColumn];

            if (isset($this->revenue[$assetLabels])) {
                $this->revenue[$assetLabels] += $revenue;
            } else {
                $this->revenue[$assetLabels] = $revenue;
            }
        }

        fclose($handle);
    }

    private function checkIfColumnMissing()
    {
        return $this->revenueColumn === null || $this->assetLabelsColumn === null;
    }

    private function skippedLinesIgnored()
    {
        return $this->line > $this->reportType['skip_lines'];
    }

    private function insertRevenue()
    {
        foreach ($this->revenue as $assetLabel => $revenue) {
            $assetLabelRaw = AssetLabel::where('name', $assetLabel)->first();

            if ($assetLabelRaw && $assetLabelRaw->user) {
                Earning::create([
                    'user_id' => $assetLabelRaw->user->id,
                    'amount' => $revenue / 100 * $assetLabelRaw->user->revenue_share,
                    'earning_run_id' => $this->report->earningRun->id
                ]);
            }
        }
    }

    private function markAsInProgress()
    {
        $this->report->update(['status' => 'parsing']);
    }

    private function markFinished()
    {
        $this->report->update(['status' => 'finished']);
    }
}

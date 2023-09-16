<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\EarningRun;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request, EarningRun $earningrun)
    {
        $path = $request->file('file')->store('reports');

        Report::create([
            'type' => $request->input('report_type'),
            'status' => 'new',
            'file_path' => $path,
            'earning_run_id' => $earningrun->id
        ]);

        flash('Report has been added');
        return redirect()->back();
    }
}

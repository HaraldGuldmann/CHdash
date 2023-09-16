<?php

namespace App\Http\Controllers;

use App\Models\EarningRun;
use Illuminate\Http\Request;
use League\Csv\Writer;

class EarningRunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earningRuns = EarningRun::paginate(12);

        return view('earningruns.index', compact('earningRuns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('earningruns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        EarningRun::create([
            'month' => $request->input('month'),
            'year' => $request->input('year'),
        ]);

        flash('Earning Run has been created.');
        return redirect()->route('earningruns.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EarningRun $earningrun
     * @return \Illuminate\Http\Response
     */
    public function edit(EarningRun $earningrun)
    {
        return view('earningruns.edit', compact('earningrun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EarningRun $earningrun
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(EarningRun $earningrun)
    {
        $earningrun->delete();

        return redirect()->back();
    }

    /**
     * Lock Earning Run.
     *
     * @param EarningRun $earningrun
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(EarningRun $earningrun)
    {
        $earningrun->update([
            'locked' => true
        ]);

        flash('Earning Run has been locked and will be processed soon.');
        return redirect()->route('earningruns.index');
    }

    public function paid(EarningRun $earningrun)
    {
        foreach ($earningrun->earnings as $earning) {
            $earning->paid = true;
            $earning->save();
        }

        flash('Earning Run has been marked as paid.');
        return redirect()->route('earningruns.index');
    }

    public function paypal(EarningRun $earningrun)
    {
        $earnings = $earningrun->earnings()->whereHas('user', function($q)
        {
            $q->where('payment_method', '=', 'paypal');

        })->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject);

        $csv->insertOne(['Hi']);

        foreach ($earnings as $person) {
            $csv->insertOne($person->toArray());
        }

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="people.csv"',
        ]);
    }
}

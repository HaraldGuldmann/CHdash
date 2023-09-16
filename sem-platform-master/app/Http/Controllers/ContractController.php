<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContractRequest;
use App\Http\Requests\SignContractRequest;
use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractSignInvitation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('create', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = auth()->user()->contracts;

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContractRequest $request)
    {
        $user = User::findOrFail($request->input('user_id'));

        $path = $request->file('file')->store('contracts');

        $contract = Contract::create([
            'name' => $request->input('name'),
            'file_path' => $path,
            'user_id' => $user->id
        ]);

        $user->notify(new ContractSignInvitation($contract));

        flash('Contract has been created and invitation has been sent.');

        return redirect()->route('contracts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        if($contract->user_id !== auth()->user()->id){
            abort(403);
        }

        return view('contracts.show', compact('contract'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Contract $contract)
    {
        $contract->delete();

        return redirect()->back();
    }

    public function sign(Contract $contract)
    {
        if (!is_null($contract->signed_at)) {
            flash('This agreement was already signed by you.');
            return redirect()->route('contracts.index');
        }

        return view('contracts.sign', compact('contract'));
    }

    public function patchSign(SignContractRequest $request, Contract $contract)
    {
        $contract->update([
            'signature' => $request->input('full_legal_name'),
            'signed_at' => Carbon::now(),
        ]);

        flash('Contract has been signed!');
        return redirect()->route('contracts.index');
    }
}

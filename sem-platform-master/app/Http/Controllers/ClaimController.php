<?php

namespace App\Http\Controllers;

use App\Enums\ClaimStatusEnum;
use App\Enums\MatchPolicyEnum;
use App\Enums\ReferenceContentTypeEnum;
use App\Models\Claim;
use App\Rules\YouTubeUrlRule;
use Illuminate\Http\Request;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->is_admin) {
            $claims = Claim::where('status', ClaimStatusEnum::pending())->paginate(25);
        } else {
            $claims = auth()->user()->claims()->where('status', ClaimStatusEnum::pending())->paginate(25);

            if(!empty(request()->get('status'))){
                $claims = auth()->user()->claims()->where('status', ClaimStatusEnum::{request()->get('status')}())->paginate(25);
            }

        }

        return view('claims.index', compact('claims'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('claims.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'video_url'       => ['required', new YouTubeUrlRule(), 'unique:claims,video_url'],
            'timestamp_start' => [],
            'timestamp_end'   => [],
            'match_policy'    => ['required', new EnumRule(MatchPolicyEnum::class)],
            'content_type'    => ['required', new EnumRule(ReferenceContentTypeEnum::class)]
        ]);

        $data['user_id'] = auth()->user()->id;

        $claim = Claim::create($data);

        flash('Video has been added and will be reviewed by one of our admins.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Claim $claim
     *
     * @return void
     */
    public function show(Claim $claim)
    {
        return view('claims.show', compact('claim'));
    }

    public function claim(Claim $claim)
    {
        $claim->update([
            'status' => ClaimStatusEnum::claimed()
        ]);

        // TODO: Claim Notification?

        flash('Video will be claimed');

        return redirect()->back();
    }

    public function reject(Claim $claim)
    {
        $claim->update([
            'status' => ClaimStatusEnum::rejected()
        ]);

        flash('Video has been rejected');

        return redirect()->back();
    }
}

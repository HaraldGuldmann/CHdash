<?php

namespace App\Http\Controllers;

use App\Enums\VideoStatusEnum;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\CreateReferenceJob;
use App\Models\Video;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('approve', 'deny', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->is_admin) {
            $videos = Video::where('status', VideoStatusEnum::pending())->paginate(20);
        } else {
            $videos = auth()->user()->videos()->where('status', VideoStatusEnum::pending())->paginate(20);

            if(!empty(request()->get('status')))
            {
                $videos = auth()->user()->videos()->where('status', VideoStatusEnum::{request()->get('status')}())->paginate(20);
            }
        }

        return view('videos.index', compact('videos'));
    }

    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request)
    {
        $path = $request->file('file')->store('videos');

        Video::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'file_path' => $path,
            'user_id' => auth()->user()->id,
            'content_type' => $request->input('content_type'),
            'isrc' => $request->input('isrc'),
            'album' => $request->input('album'),
            'artist' => $request->input('artist'),
            'status' => VideoStatusEnum::pending()
        ]);

        flash('Video has been added and will be reviewed by one of our admins.');

        return redirect()->back();
    }

    public function approve(Video $video)
    {
        $video->update([
            'status' => VideoStatusEnum::approved()
        ]);

        CreateReferenceJob::dispatch($video);

        flash('Video has been approved');

        return redirect()->back();
    }

    public function deny(Video $video)
    {
        $video->update([
            'status' => VideoStatusEnum::denied()
        ]);

        flash('Video has been denied');

        return redirect()->back();
    }
}

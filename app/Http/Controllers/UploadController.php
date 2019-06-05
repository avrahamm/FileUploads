<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faker\Provider\Uuid as FakerUuid;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userUploads = $user->uploads()->get(['uuid','name']);
        return view('uploads.index')->with('userUploads', $userUploads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("uploads.create");
    }

    /**
     * uuid is generated so when building downloading link,
     * uuid will be used and not id.
     * So the real id is not guessable and more secure.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'fileToUpload' => 'required|file|max:1024|mimes:pdf,doc,docx,jpeg,jpg,png,gif',
        ]);

        $uploadedFile = $request->fileToUpload;
        $upload = new Upload;
        $upload->create([
            'user_id' => Auth::id(),
            'uuid' => FakerUuid::uuid(),
            'name' => $uploadedFile->getClientOriginalName(),
            'data' => $uploadedFile->get()
        ]);
        return back()
            ->with('success','successfully uploaded.');
    }

    /**
     * When download link is clicked, comes here and
     * a browser is forced to download file.
     * The filed is searched among current user files by $uuid parameter.
     * @param $uuid
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($uuid)
    {
        $user = Auth::user();
        $targetUpload = $user->uploads()->where('uuid',$uuid)->FirstOrFail();
        $fileName = $targetUpload->name;
        $decryptedContent = $targetUpload->data;
        return response()->streamDownload(function() use ($decryptedContent, $fileName) {
            echo $decryptedContent;
        }, $fileName);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        return redirect(route("uploads.create"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        return redirect(route("uploads.create"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        return redirect(route("uploads.create"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        return redirect(route("uploads.create"));
    }
}

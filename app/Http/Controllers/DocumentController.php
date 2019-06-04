<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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
        $encryptedContent = Storage::get('file.dat');
        $decryptedContent = decrypt($encryptedContent);

        return response()->streamDownload(function() use ($decryptedContent) {
            echo $decryptedContent;
        }, 'file.jpg');
        //
//        return view("documents.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return "Create Document Form";
        return view("documents.create");
    }

    /**
     * TODO! delete
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storev1(Request $request)
    {
        $request->validate([
            'fileToUpload' => 'required|file|max:1024',
        ]);
//@link:https://laracasts.com/discuss/channels/laravel/how-to-get-uploaded-file-name-in-laravel-53
//        $request->fileToUpload->store('logos');
        $fileName = request()->fileToUpload->getClientOriginalName();
//        $fileName .= $fileName.time().'.'.request()->fileToUpload->getClientOriginalExtension();
        $request->fileToUpload->storeAs('logos',$fileName);

        return back()
            ->with('success','You have successfully uploaded.');
//        return redirect("/documents/create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'fileToUpload' => 'required|file|max:1024',
        ]);
        $file = $request->fileToUpload;

        // Get File Content
        $fileContent = $file->get();

        // Encrypt the Content
        $encryptedContent = encrypt($fileContent);
        $fileName = request()->fileToUpload->getClientOriginalName();
        $fileName .= ".dat";
//        $fileName .= $fileName.time().'.'.request()->fileToUpload->getClientOriginalExtension();

        // Store the encrypted Content
        Storage::put($fileName, $encryptedContent);

        return back()
            ->with('success','You have successfully uploaded.');
    }


    //==============================

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Faker\Provider\Uuid as FakerUuid;
use Exception;

/**
 * Class UploadController manages uploads operations,
 * and logs daily errors on uploads and downloads
 * to uploads and downloads logs respectively.
 * Logs definition is set in config/logging.php.
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // only authenticated user can browse uploads pages.
        $this->middleware('auth');
    }

    /**
     * Display a listing of the uploaded files for authenticated logged in user.
     * The list will include download links built with uuid instead id
     * for more security,
     * @link:https://laraveldaily.com/laravel-upload-file-and-hide-real-url-for-secure-download-under-uuid/
     * and file name for more clear error and log messages.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userUploads = $user->uploads()->get(['uuid','name']);
        return view('uploads.index')->with('userUploads', $userUploads);
    }

    /**
     * Show the upload form for creating a new resource.
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
        try {
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
        }
        catch( Exception $e){
            $fileName = "no file";
            if( $request->fileToUpload ) {
                $fileName = $request->fileToUpload->getClientOriginalName();
            }

            $logMessage = $this->getLogMessage($e->errors()['fileToUpload'][0],
                $fileName);
            Log::channel('uploads')->error($logMessage);
            return back()->withErrors($e->errors());
        }
        // on success
        return back()
            ->with('success','successfully uploaded.');
    }

    /**
     * To prepare log message.
     * @param $description
     * @param null $fileName
     * @return string
     */
    public function getLogMessage($description, $fileName=null) {
      $user = Auth::user();
      $userId = $user->id;
      $userName = $user->name;
      $logMessage = "userId = $userId, userName = $userName, fileName = $fileName, $description";
      return $logMessage;
    }

    /**
     * When download link is clicked, comes here and
     * a browser is forced to download file.
     * The filed is searched among current user files by $uuid parameter.
     * $targetName is used with failed message when download failed.
     * @param $uuid
     * @param $targetName
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($uuid,$targetName)
    {
        try {
            $user = Auth::user();
            $targetUpload = $user->uploads()->where('uuid',$uuid)->FirstOrFail();
            $fileName = $targetUpload->name; // should equal $targetName.
            $decryptedContent = $targetUpload->data;
            return response()->streamDownload(function() use ($decryptedContent, $fileName) {
                echo $decryptedContent;
            }, $fileName);
        }
        catch ( Exception $e) {
            $logMessage = $this->getLogMessage("Download Failed",$targetName);
            Log::channel('downloads')->error($logMessage);
            return back()->withErrors("$targetName File Not found");
        }
    }
}

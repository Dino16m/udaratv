<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validator;
use App\Constants;
use App\Events\downloadEvent;
use Illuminate\Support\Facades\Storage;

class downloadController extends Controller
{
    public function download(Request $request, $Type, $QualityId)
    {
        $Path = $request->get('file');
        $Type = Validator::sanitize($Type);
        $type = strtolower($Type);
        $path = Validator::sanitize($Path);
        $id = Validator::sanitize($QualityId);
        $base_path = base_path('storage/app'.$path);
        if(!Validator::isInt($id) /**|| preg_match('~/videos/~', $path)==0 **/ )
        {
            return back();
        }
        $name= basename($path);
        $UA = strtolower($request->header('User-Agent'));
        if(file_exists($base_path)){
          return $this->downloadLocalFile($name, $path, $UA, $type, $id);
        }
        elseif(Storage::disk('ext0')->exists($path)){
           return $this->downloadCloudFile($name, $path, $UA, $type, $id);
        }
        elseif (preg_match('~/videos/~', $path)==0) {
            $to = $path;
            return redirect()->away($to);
        }
        else{
            return back();
        }
    }

    private function downloadCloudFile($name, $path, $UA, $type, $id)
    {
        $path = substr($path, 1);
        $mime_type=Storage::disk('ext0')->mimeType($path);
        $mime = $mime_type == false ? 'video/mp4' : $mime_type;
        $file_size = Storage::disk('ext0')->size($path);
        ob_end_clean();
        $headers = array('Content-Type'=>$mime,
                           'Content-Length'=>$file_size);
        event( new downloadEvent(['type'=>$type, 'id'=>$id]));
        if(strpos($UA, 'ucbrowser') !==false && strpos($UA, 'mobile')!==false){
            $to = Storage::disk('ext0')->url($path);
            return redirect()->away($to);
        }
        return ($name && Storage::disk('ext0')->exists($path)) ? Storage::disk('ext0')->download($path, $name, $headers) : back();
    }

    private function downloadLocalFile($name, $path, $UA, $type, $id)
    {
        $base_path = base_path('storage/app'.$path);
        $mime_type = mime_content_type($base_path);
        $mime = $mime_type === false ? 'video/mp4' : $mime_type;
        $file_size = file_exists($base_path) ? filesize($base_path) : 0; 
        ob_end_clean();
        $headers = array('Content-Type'=>$mime,
                           'Content-Length'=>$file_size);
        event( new downloadEvent(['type'=>$type, 'id'=>$id]));
        if(strpos($UA, 'ucbrowser') !==false && strpos($UA, 'mobile')!==false){
            $to = url('storage/app'.$path);
            return redirect()->away($to);
        }
        return ($name && Storage::exists($path)) ? Storage::download($path, $name, $headers) : back();
    }
}

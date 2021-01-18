<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FSController extends Controller
{
    private $base;

    public function __construct() 
    {
        $this->base = 'doc';
    }

    public function index(Request $request, $url = '') 
    {
        $base = $this->base;

        $dir = $url;
        $data['path'] = 'C:/' . $base . '/' . $url;

        $data['parent'] = '';
        if ($url !== '') {
            $req_url = $request->url();
            $strlen = mb_strlen($req_url);
            if (mb_substr($req_url, ($strlen - 1) ,1) == '/') {
                $req_url = mb_substr($req_url, 0, ($strlen - 1));
            }
            $pos = 0;
            do  {
                $pos = mb_strrpos($req_url, '/');
            } while($pos === 0);
            $data['parent'] = mb_substr($req_url, 0, $pos);        
        }


        $dirs = Storage::disk($base)->directories($dir);
        $data['dcount'] = count($dirs);
        if (count($dirs)) {
            $data['dirs'] = $this->getItems($base,$dirs);
        } else {
            $data['dirs'] = '';
        }

        $files = Storage::disk($base)->files($dir);
        $data['fcount'] = count($files);
        if (count($files)) {
            $data['files'] = $this->getItems($base,$files);
        } else {
            $data['files'] = '';
        }
        
        return view('hello.index', $data);
    }
   
    private function getItems($base, $urls) {
        $items = [];
        foreach ($urls as $url) {
            $item = [];
            $item['path'] = 'C:/' . $base . '/' . $url;
            $paths = explode('/', $url);
            $item['url'] = $paths[count($paths) - 1];
            $item['size'] = '';
            $lastModified = date('Y-m-d H:i:s', Storage::disk($base)->lastModified($url));
            $item['lastModified'] = $lastModified;
            if (Storage::disk($base)->getMetaData($url)['type'] == 'dir') {
                $dirs =  Storage::disk($base)->directories($url);
                $files =  Storage::disk($base)->files($url);
                $item['size'] =  count($dirs) . " dirs; " . count($files) . " files";
            } else {
                $item['size'] = Storage::disk($base)->size($url);
            };

            array_push($items, $item);
        }
        return $items;
    }


    public function upload(Request $request, $url = '') 
    {
        $base = $this->base;
        $currentdir = $request->currentdir;
        if ($currentdir != '') {
            $pos = mb_strrpos($currentdir, '/FS');
            if ($pos > 0) {
                $currentdir = mb_substr($currentdir, ($pos + 3) );
                if (mb_substr($currentdir, 0, 1) == '/') {
                    $currentdir = mb_substr($currentdir, 1);
                }
            }
        }

        print $currentdir;
        var_dump($request->file('file'));
        print $request->filename;
        // return;
        $dir = $currentdir;
        $path = 'C:/' . $base .  '/' . $dir;
        $data['path'] = $path;

        $data['parent'] = '';
        if ($dir !== '') {
            $req_url = $request->url();
            $strlen = mb_strlen($req_url);
            if (mb_substr($req_url, ($strlen - 1) ,1) == '/') {
                $req_url = mb_substr($req_url, 0, ($strlen - 1));
            }
            $pos = 0;
            do  {
                $pos = mb_strrpos($req_url, '/');
            } while($pos === 0);
            $data['parent'] = mb_substr($req_url, 0, $pos); 
        }

        Storage::disk($base)->putFileAs('/' .$dir, $request->file('file'), $request->filename);
        
        return redirect()->route('index', ['url'=>$dir]);
    }
}
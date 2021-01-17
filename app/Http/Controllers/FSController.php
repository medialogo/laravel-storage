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

    public function index($url = '') 
    {
        $base = $this->base;

        $dir = $url;
        $data['path'] = 'C:/' . $base . '/' . $url;


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


    public function other($msg)
    {
        // $data = Storage::get($this->filename) . PHP_EOL . $msg;
        Storage::append($this->filename, $msg);
        return redirect()->route('hello');
    }
}
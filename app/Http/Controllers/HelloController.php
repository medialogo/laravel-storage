<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelloController extends Controller
{
    private $filename;

    public function __construct() 
    {
        $this->filename = '.gitignore';
    }

    public function index() 
    {
        $base = 'local';
        $dir = '/';
        $urls = Storage::disk($base)->allfiles($dir);
        $items = [];
        $data['files'] = [];
        foreach ($urls as $url) {
            $item = [];
            $item['url'] = $url;
            $item['size'] = Storage::disk($base)->size($url);
            $lastModified = date('y-m-d H:i:s', Storage::disk($base)->lastModified($url));
            $item['lastModified'] = $lastModified;
            array_push($data['files'], $item);
        }

        // $size = Storage::disk($base)->size($this->filename);
        // $modified = Storage::disk($base)->lastModified($this->filename);
        // $lastModified = date('y-m-d H:i:s', $modified);
        
        return view('hello.index', $data);
    }

    public function other($msg)
    {
        // $data = Storage::get($this->filename) . PHP_EOL . $msg;
        Storage::append($this->filename, $msg);
        return redirect()->route('hello');
    }
}
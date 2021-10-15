<?php

namespace App\Http\Controllers;

use App\Book;
use GuzzleHttp\Psr7\FnStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        chdir(__DIR__);
    }

    public function mysql(Request $request)
    {


        $books = Book::where('title', 'LIKE', $request->get('title'))
            ->whereRaw("era_id IN (SELECT id FROM eras WHERE year = {$request->get('year')})")->get();

        return response()->json($books);
    }

    public function rce($file)
    {
        $payload = file_get_contents($file);
        unserialize($payload);
    }

    public function image(Request $request)
    {

        var_dump(mime_content_type("loaded.jpg"));

        if (file_exists($request->get("filename"))) {
            echo "File exists";
        }
    }
    //
}

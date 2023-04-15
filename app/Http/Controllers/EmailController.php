<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use App\Jobs\SendTestMailJob;

class EmailController extends Controller
{
    //

    public function sendemail($id){

        $book = book::find($id);
        dispatch(new  SendTestMailJob($book));

        dd('email has been sent ');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller
{
    /**
     * test function
     *
     * @return void
     */
    public function welcome()
    {
        return view('welcome', ['hello' => 'Hello World', 'gender' => 'M']);
    }

    public function mail()
    {
        Mail::send('welcome', ['name' => "ABC"], function ($message) {
            $message
                ->to('cgm.myominhtay@gmail.com', 'Receiver ABC')
                ->subject('Laravel Basic Testing Mail')
                ->from('xyz@gmail.com', 'Sender ABC');
        });
        dd('mail sent');
    }
}

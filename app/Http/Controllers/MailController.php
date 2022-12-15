<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;

class MailController extends Controller
{
 
    public function sendMail(Request $request)
    {
        // $users = User::all();

        $mail_data = [
            'subject' => 'New message subject.'
        ];
        
        $job = (new SendEmail($mail_data))
                ->delay(now()->addSeconds(2)); 

        dispatch($job);
        
        echo ("Job dispatched.");
    }    



}

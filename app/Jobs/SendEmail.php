<?php

namespace App\Jobs;


use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $mail_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();

        $input['subject'] = $this->mail_data['subject'];

        foreach ($users as $key => $value) {
            $input['email'] = $value->email;
            $input['name'] = $value->name;
            
            Mail::send('mails.mail', [], function($message) use($value,$input){
                $message->to($input['email'],$input['name'])
                       ->subject($input['subject']);
            });
        }
    }
}

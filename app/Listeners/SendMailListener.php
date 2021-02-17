<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SendMail;
use Snowfire\Beautymail\Beautymail;

class SendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $beautyMail = app()->make(Beautymail::class);
        $beautyMail->send($event->view, ['otpCode' => $event->otpCode], function($message) use ($event){
            $message->to($event->email)->subject($event->subject);
        });
    }
}

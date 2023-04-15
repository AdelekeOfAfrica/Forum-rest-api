<?php

namespace App\Jobs;

use App\Models\book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\SendMarkDownMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendTestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public book $book;

    /**
     * Create a new job instance.
     */
    public function __construct(book $book)
    {
        //
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
      
        Mail::to("awotundunmicheal@gmail.com")->send(new SendMarkDownMail($this->book)); #this-user->email if it had email
    }
}

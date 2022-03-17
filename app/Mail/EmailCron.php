<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailCron extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The resource instance.
     *
     * @var \App\Models\Emails|\App\Models\Transactions
     */
    protected $resource;

    /**
     * The email template to use.
     *
     * @var 'payment'|'register'|'raw'
     */
    protected $template;

    /**
     * Create a new message instance.
     *@param \App\Models\Emails|\App\Models\Transactions $email
     *@param 'payment'|'register'|'raw' $template
     * @return void
     */
    public function __construct($resource, $template='raw')
    {
        $this->resource = $resource;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = $this->template === 'raw' ? 'New Notification' : ( $this->template === 'register' ? 'register' : 'Payment Notification');
        $resource = $this->resource;
        return $this->markdown('emails.'.$this->template, compact('resource'));
    }
}

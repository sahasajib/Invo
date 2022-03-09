<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user           =  $this->data['user'];
        $client         =  $this->data['invoice']->client;
        $invoice_id     =  $this->data['invoice_id'];
        $pdf            = $this->data['pdf'];
        return $this->markdown('email.invoice',['client'=>$client])
                    ->from($user->email,$user->name)
                    ->subject($invoice_id)
                    ->attach($pdf,['mime' => 'application/pdf']);
                  //  ->attachData($pdf,$invoice->download_url,[ 'mime' => 'application/pdf']);;
    }
}

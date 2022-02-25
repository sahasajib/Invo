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
        $invoice        =  $this->data['invoice'];
        $client         =  $this->data['invoice']->client;
        $invoice_id     =  $this->data['invoice_id'];
       // $pdf            = $this->data['pdf'];
        $pdf            = public_path('storage/invoice/'.$invoice->download_url);
        return $this->markdown('email.invoice')
                    ->from($user->email,$user->name)
                    ->to($client->email,$client->name)
                    ->subject($invoice_id)
                    ->attach($pdf,['mime' => 'application/pdf']);
                  //  ->attachData($pdf,$invoice->download_url,[ 'mime' => 'application/pdf']);;
    }
}

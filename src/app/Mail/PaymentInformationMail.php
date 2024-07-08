<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentInformationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $item;
    public $paymentMethod;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $item, $paymentMethod)
    {
        $this->user = $user;
        $this->item = $item;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->paymentMethod == 'bank_transfer') {
            return $this->subject('銀行振込の支払い情報')
                        ->view('emails.payment_information_bank');
        } else {
            return $this->subject('コンビニ払いの支払い情報')
                        ->view('emails.payment_information_convenience_store');
        }
    }
}

<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Orders_details;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderOutOfStock extends Mailable
{

    // khi sản phẩm không đủ hàng
    use Queueable, SerializesModels;

    public $orderDetail;
    public $order;

    public function __construct(Order $order,Orders_details $orderDetail)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    public function build()
    {
        return $this->view('emails.order_out_of_stock')
                    ->subject('Thông báo: Sản phẩm không đủ hàng');
    }
}

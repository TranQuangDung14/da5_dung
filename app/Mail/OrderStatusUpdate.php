<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {

        $statusTexts = [
            1 => 'Đang chờ xử lý',
            2 => 'Đã xác nhận đơn hàng',
            3 => 'Đang giao',
            4 => 'Hoàn thành',
            5 => 'Hủy đơn'
        ];
        $statusText = $statusTexts[$this->order->status];

    $orderDetails = $this->order->orderDetails()->with('product')->get();
        return $this->view('emails.order_status_update')
                    ->subject('Thông báo: Cập nhật trạng thái đơn hàng')
                    ->with('statusText', $statusText)
                    ->with('orderDetails', $orderDetails);
    }
}

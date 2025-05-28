<?php

namespace App\Enums;

enum OrderStatusEnum : string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case SHIPPED = 'shipped';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
    case DELIVERED = 'delivered';

    case PENDING = 'pending';
    case PROCESSING = 'processing';


    public function color(): string
    {
        return match ($this) {
            self::UNPAID, self::PENDING, self::PROCESSING => 'warning',
            self::PAID, self::DELIVERED => 'success',
            self::SHIPPED => 'info',
            self::CANCELED, self::REFUNDED => 'danger',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::PAID => 'Paid',
            self::SHIPPED => 'Shipped',
            self::CANCELED => 'Canceled',
            self::REFUNDED => 'Refunded',
            self::DELIVERED => 'Delivered',
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
        };
    }
}

<?php

namespace App\Enums;

enum FlashSaleStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Scheduled = 'scheduled';
    case Ended = 'ended';
}

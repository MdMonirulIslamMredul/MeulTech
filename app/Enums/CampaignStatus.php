<?php

namespace App\Enums;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Scheduled = 'scheduled';
    case Expired = 'expired';
}

<?php

namespace App\Enums;

enum RequestServiceStatusEnum: string
{
    case SUBMITTED = 'submitted';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}

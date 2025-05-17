<?php

namespace App\Enums;

enum ProblemStatusEnum: string
{
    case OPENED = 'opened';
    case CLOSED = 'closed';
}

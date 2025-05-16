<?php

namespace App\Enums;

enum IncidentStatus: string
{
    case SUBMITTED = 'submitted';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
}


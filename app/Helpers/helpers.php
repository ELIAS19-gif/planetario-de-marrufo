<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Orden;

function hoy($formato = 'Y-m-d H:i:s')
{
    return now()->format($formato);
}
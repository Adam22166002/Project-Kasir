<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    protected $fillable = ['description', 'amount', 'type', 'modal_date'];
}

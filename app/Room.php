<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table='rooms';
    protected $fillable=[
        'topic_id',
        'status',
        'assignee',
        'created_at',
        'customer_id',
        'closed_at'
    ];

    public $timestamps=false;
}

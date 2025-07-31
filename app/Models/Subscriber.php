<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Inkwell\Database\Factories\SubscriberFactory;

class Subscriber extends Model
{
    /** @use HasFactory<\Inkwell\Database\Factories\SubscriberFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    protected static function newFactory(): SubscriberFactory
    {
        return SubscriberFactory::new();
    }
}

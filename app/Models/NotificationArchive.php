<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationArchive extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'data', 'created_at', 'updated_at'];

    protected $table = 'notification_archives';
}

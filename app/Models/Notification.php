<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'is_read',
    ];

    public $timestamps = false; // Vì chỉ có created_at, không có updated_at

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Quan hệ: Notification thuộc về một User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

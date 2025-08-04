<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime'
    ];

    // Status constants
    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';

    public function markAsRead()
    {
        $this->update(['status' => self::STATUS_READ]);
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => self::STATUS_REPLIED,
            'replied_at' => now()
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function addHistory($data)
    {
        $this->query()->create([
            'type' => $data['type'],
            'action' => $data['action'],
            'note' => $data['note'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
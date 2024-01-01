<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    public $guarded = ['id'];

    public function technicals()
    {
        return $this->hasMany(Technical::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
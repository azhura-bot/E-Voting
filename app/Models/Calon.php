<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calon extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'deskripsi', 'image_path'
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
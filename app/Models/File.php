<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'UUID_FILE';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['UUID_FILE', 'UUID_USER', 'UUID_DIR', 'name', 'size', 'type', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UUID_USER', 'UUID_USER');
    }

    public function directory()
    {
        return $this->belongsTo(Dir::class, 'UUID_DIR', 'UUID_DIR');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'file_tag', 'UUID_FILE', 'UUID_TAG');
    }
}
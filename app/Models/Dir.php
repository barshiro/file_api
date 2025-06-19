<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dir extends Model
{
    protected $table = 'dirs';
    protected $primaryKey = 'UUID_DIR';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['UUID_DIR', 'UUID_USER', 'name', 'parent_dir'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UUID_USER', 'UUID_USER');
    }

    public function parent()
    {
        return $this->belongsTo(Dir::class, 'parent_dir', 'UUID_DIR');
    }

    public function children()
    {
        return $this->hasMany(Dir::class, 'parent_dir', 'UUID_DIR');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'UUID_DIR', 'UUID_DIR');
    }
}
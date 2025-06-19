<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'UUID_TAG';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['UUID_TAG', 'name'];

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_tag', 'UUID_TAG', 'UUID_FILE');
    }
}
<?php

namespace MagicMirror;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function modules() {
        return $this->hasMany("MagicMirror\Module");
    }
}

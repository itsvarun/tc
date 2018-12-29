<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Task;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function tasks() {
    	return $this->hasMany(Task::class);
    }
}

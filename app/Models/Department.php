<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Department;

class Department extends Model
{
     protected $fillable = [
        'name',
        'description',
    ];//
}

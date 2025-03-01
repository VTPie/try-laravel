<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'todo_info';

    /**
     * Indicates if the model should be timestamped.
     * Disable created_at and updated_at columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     * Specify the fields that can be saved using mass assignment
     *
     * @var array
     */
    protected $fillable = ['name', 'priority', 'deadline', 'status'];
}

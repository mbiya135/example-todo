<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @@method static create(array $array):Todo
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment_id',
        'description',
        'user_id',
        'todo_id',
        'created_at',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}

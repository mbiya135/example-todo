<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array):Todo
 * @method static where(string $string, string $uuid)
 */
final class Todo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'description',
        'user_id',
        'status',
        'created_at',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @param string $uuid
     * @return static
     */
    public static function uuid(string $uuid): ?self
    {
        return Todo::where('uuid', $uuid)->first();
    }
}

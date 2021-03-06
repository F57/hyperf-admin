<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use App\Model\ModelTrait\ModelTrait;
use Donjan\Permission\Traits\HasRoles;
use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int $id 
 * @property string $name 
 * @property string $email 
 * @property string $passwd 
 * @property string $photo 
 * @property int $role 
 * @property string $access 
 * @property string $ip 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Admin extends Model
{
    use ModelTrait;
    use HasRoles;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'role' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
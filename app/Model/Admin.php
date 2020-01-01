<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use Hyperf\Database\Model\SoftDeletes;
use App\Model\ModelTrait;
use Donjan\Permission\Traits\HasRoles;

/**
 * @property int $id 
 * @property string $name 
 * @property string $email 
 * @property string $email_verified 
 * @property string $passwd 
 * @property string $photo 
 * @property int $role 
 * @property string $access 
 * @property int $c_id 
 * @property int $d_id 
 * @property float $total 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Admin extends Model
{
    use SoftDeletes;

    use ModelTrait;

    use HasRoles;

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
    protected $casts = ['id' => 'integer', 'role' => 'integer', 'c_id' => 'integer', 'd_id' => 'integer', 'total' => 'float', 'created_at' => 'datetime', 'updated_at' => 'datetime'];


}
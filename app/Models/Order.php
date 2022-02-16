<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Order extends Model implements JWTSubject
{
    protected $connection= 'pgsql';
    protected $table = 'orders';

    protected $fillable = [
        'id_customer',
        'order_code',
        'order_name',
        'order_date',
        'status',
        'description',
        'is_active',
        'created_by',
        'created_at',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

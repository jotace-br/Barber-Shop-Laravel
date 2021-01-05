<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'value',
        'description',
        'observation',
        'fk_sector',
        'fk_user',
        'request_date',
        'request_stage',
        'url',
        'quantity'
    ];

      protected $guarded = ['id'];

      /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
      protected $hidden = [
        'created_at',
        'updated_at'
      ];

      protected $table = 'purchase_requests';

      public function fk_user() {
        return $this->hasOne('App\Models\UserType', 'id', 'fk_user');
    }

    public function fk_sector() {
        return $this->hasOne('App\Models\Sector', 'id', 'fk_sector');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'motif',
        'room',
        'start_at',
        'end_at',
        'date',
        'status',
        'fk_user',
        'fk_sector'
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
    protected $table = 'meetings';

    public function fk_user() {
        return $this->hasOne('App\Models\UserType', 'id', 'fk_user');
    }

    public function fk_sector() {
        return $this->hasOne('App\Models\Sector', 'id', 'fk_sector');
    }

}

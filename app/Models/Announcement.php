<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'announcement_date',
        'description',
        'fk_user',
        'fk_sector',
        'status',
        'url_link'
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

      protected $table = 'announcements';

    public function fk_user() {
        return $this->hasOne('App\Models\UserType', 'id', 'fk_user');
    }

    public function fk_sector() {
        return $this->hasOne('App\Models\Sector', 'id', 'fk_sector');
    }
}

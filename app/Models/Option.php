<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Option extends Model
{
    public $timestamps = false;
    protected $fillable = ['grp','name','price_add','is_multi','sort','active'];
    protected $casts = ['is_multi'=>'boolean','active'=>'boolean'];
}

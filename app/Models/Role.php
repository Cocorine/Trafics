<?php

namespace App\Models;

use App\Traits\Eloquents\RoleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, RoleTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table='roles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey='id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Indicates if the model should be softdeleted.
     *
     * @var bool
     */
    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id',
        'name',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $with = ['permissions'];

     /**
     * Get the role's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value){
        return ucfirst(str_replace('\\',' ',$value)); // Converts the first character of role's name to uppercase
    }


    /**
     * Set the role's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = addslashes($value); // Escape value with backslashes
    }


     /**
     * Get the role's slug.
     *
     * @param  string  $value
     * @return string
     */
    public function getSlugAttribute($value){
        return strtolower(str_replace('\\',' ',$value)); // Converts the first character of role's slug to uppercase
    }


    /**
     * Set the role's slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = addslashes($value); // Escape value with backslashes
    }


}

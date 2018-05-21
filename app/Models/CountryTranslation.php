<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    //
	use Translatable;
	
	public $timestamps = false;
	
	protected  $fillable = ['name'];
}

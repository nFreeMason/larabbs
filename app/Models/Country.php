<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
	use Translatable;
	
	public $translatedAttributes = ['name'];
	
	protected $fillable = ['code'];
	
	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
//	 (optionaly)
	// protected $with = ['translations'];
}

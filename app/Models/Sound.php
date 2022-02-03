<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 * Sound
 *
 * @mixin Builder
 */
class Sound extends Model {


	use HasFactory, Sluggable, Taggable;


	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable(): array {
		return [
			'slug' => [
				'source' => 'title'
			]
		];
	}

	protected $fillable = [
		'user_id',
		'name',
		'description',
		'slug',
		'duration_seconds',
		'duration_string',
		'file_size',
		'bit_depth',
		'bit_rate',
		'sample_rate',
		'file_url'
	];


}

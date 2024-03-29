<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categories';

    protected $fillable = [
        'category_name',
    ];

    public $timestamps= true;

    public function activityTypes() {
    	return $this->hasMany(ActivityType::class);
    }

    public function providers() {
    	return $this->belongsTo(Provider::class);
    }
}

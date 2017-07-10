<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'title', 'trip_date', 'trip_duration', 'description', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function form()
    {
        return [
            'title' => '',
            'trip_date' => '',
            'trip_duration' => '',
            'description' => '',
            'image' => ''
        ];
    }
}

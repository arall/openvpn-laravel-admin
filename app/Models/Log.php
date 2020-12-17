<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Location;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_ip',
        'client_port',
        'client_location',
        'remote_ip',
        'remote_port',
        'bytes_received',
        'bytes_sent',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($log) {
            $log->start_time = Carbon::now();
        });

        static::created(function ($log) {
            $log->client_location = Location::get($log->client_ip)->countryName;
            $log->save();
        });
    }

    /**
     * Search active query scope.
     *
     * @param Builder $query
     * @param bool $active
     * @return Builder
     */
    public function scopeActive(Builder $query, bool $active)
    {
        if ($active) {
            return $query->whereNull('end_time');
        }

        return $query->whereNotNull('end_time');
    }

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

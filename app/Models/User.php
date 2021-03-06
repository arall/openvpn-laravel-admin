<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Set the user as online.
     */
    public function setOnline()
    {
        $this->is_online = 1;
        $this->save();
    }

    /**
     * Set the user as offline.
     */
    public function setOffline()
    {
        $this->is_online = 0;
        $this->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->google_photo_url ?: $this->defaultProfilePhotoUrl();
    }

    /**
     * Search query scope.
     *
     * @param Builder $query
     * @param string  $string
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $string)
    {
        return $query->where('name', 'like', '%' . $string . '%')->orWhere('email', 'like', '%' . $string . '%');
    }

    /**
     * Search online query scope.
     *
     * @param Builder $query
     * @param bool $online
     * @return Builder
     */
    public function scopeOnline(Builder $query, bool $online)
    {
        return $query->where('is_online', $online);
    }

    /**
     * Get all of the logs for the user.
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}

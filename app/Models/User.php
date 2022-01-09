<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_admin',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Custom methods
     */
    public function isSuperAdmin() :bool
    {
        return $this->is_admin === true;
    }

    /**
     * Custom accessors
     * https://laravel.com/docs/8.x/eloquent-mutators#accessors-and-mutators
     * https://laravel.com/docs/8.x/eloquent-serialization#appending-values-to-json
     */
    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? Storage::disk('avatars')->url($this->avatar)
            : Storage::disk('avatars')->url('default-avatar.png');
    }

    /**
     * Relationships
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function latestPost(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Post::class)->latestOfMany();
    }
}

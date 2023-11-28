<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    public function favorites()
    {
        return $this->belongsToMany(Place::class, 'favorites');
    }
}

class User extends Authenticatable implements FilamentUser
{
    // ...
 
    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }
}
class User extends Authenticatable implements FilamentUser, HasAvatar
{
    // ...
 
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
class User extends Authenticatable implements FilamentUser, HasName
{
    // ...
 
    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
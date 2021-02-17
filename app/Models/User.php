<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * get list of post in favorite
     *
     * @return BelongsToMany
     */
    public function favorite(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favorite');
    }

    public function liked(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }

    public function interests()
    {
        return Category::join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->join('posts', 'category_post.post_id', '=', 'posts.id')
            ->groupBy('categories.id')
            ->orderBy('count', 'desc')
            ->get(['categories.*', DB::raw('count(categories.id) as count')]);
    }

    public function avatar($size = 'md') {
        return 'tete';
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'news_id', 'name', 'email', 'comment', 'type', 'approved'];

    public function children() {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function getParentNameAttribute() {
        return $this->parent->name;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLatestParent()
    {
        if ($this->parent)
            return $this->parent->getLatestParent();
        return $this->id;
    }
}

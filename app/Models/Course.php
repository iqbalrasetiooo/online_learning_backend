<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Author;
use App\Models\Category;
use App\Models\Transaction;

class Course extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function author()
    {
        return $this->hasOne(Author::class);
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}

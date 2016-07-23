<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table="books";
    public function users() {
    	return $this->belongsToMany('App\User', 'user_books', 'book_id', 'user_id');
    }
}

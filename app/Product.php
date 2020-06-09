<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function Categories(){
        return $this->belongsToMany('App\Category');
    }

    public function getFrenchPrice()
    {
        $price = $this->price / 100 ;
        return number_format($price, 2 , ',', ' ').'E';
    }
}

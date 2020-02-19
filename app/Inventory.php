<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model {

    protected $table = "inventories";

    protected $fillable = [
        'name', 'price', 'image_url', 'merk_id', 'category_id', 'supplier_id', 'year_of_purchase'
    ];

    public function brand() {
        return $this->belongsTo('App\Brand');
    }

    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

}

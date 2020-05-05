<?php

namespace App;

use App\Notifications\StoreReiceveNewOrder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model
{

    use HasSlug;

    /*
    A variável $fillable indica o que pode ser inserido no banco pelo usuário, 
    por padrão o Laravel protege todos os campos de Mass Assignment.
    */
    protected $fillable = ['name', 'description', 'phone', 'mobile_phone', 'slug', 'logo'];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    //mapeando relacionamento entre tabelas.

    //essa loja pertence a um usuario (belongsTo)
    public function user(){

        return $this->belongsTo(User::class);
    }


    //uma loja tem muitos produtos (hasMany)
    public function products(){
        return $this->hasMany(Product::class);
    }



    public function orders(){

        return $this->belongsToMany(UserOrder::class, 'order_store', null, 'order_id');  //uma loja pode ter varios pedidods
    }


    public function notifyStoreOwners(array $storeId = []){

        $stores = $this->whereIn('id', $storeId)->get();

        $stores->map(function($store){
            return $store->user;
        })->each->notify(new StoreReiceveNewOrder());
    }
}

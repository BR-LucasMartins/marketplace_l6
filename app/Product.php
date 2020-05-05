<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

 //mapeando relacionamento entre as tabelas

class Product extends Model
{

    use HasSlug;
/*
    A variável $fillable indica o que pode ser inserido no banco pelo usuário, 
    por padrão o Laravel protege todos os campos de Mass Assignment.
    */
    protected $fillable = ['name', 'description', 'body', 'price', 'slug'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    //mapeando relacionamento entre as tabelas


    //esse produto pertence a uma loja (belongsTo)
    public function store(){
        return $this->belongsTo(Store::class);
    }


    public function categories(){

        //um produto pode pertencer a muitas categorias (n to N )
        return $this->belongsToMany(Category::class);
    }


    //esse produtop pode ter várias imagens
    public function photos(){
        return $this-> hasMany(ProductPhoto::class);
    }
}

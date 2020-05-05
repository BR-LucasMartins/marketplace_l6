<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class category extends Model
{
    //mapéando relacionamento entre tabelas

    use HasSlug;

    /*
    A variável $fillable indica o que pode ser inserido no banco pelo usuário, 
    por padrão o Laravel protege todos os campos de Mass Assignment.
    */
    protected $fillable = ['name', 'description', 'slug'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }


    public function products(){

        //uma categoria pode pertencer a varios produtos (N to N)
        return $this->belongsToMany(Product::class); //category:class refere ao nome do model 
    }
}

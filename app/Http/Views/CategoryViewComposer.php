<?php

namespace App\Http\Views;
use App\category;

class CategoryViewComposer{

    private $category;

    public function __construct(category $category)
    {
        $this->category =  $category;
    }
    public function compose($view){

        return $view->with('categories', $this->category->all(['name', 'slug']));
    }

}


?>
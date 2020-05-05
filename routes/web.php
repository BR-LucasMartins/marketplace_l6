<?php

use App\Http\Controllers\UserOrderController;

Route::get('/','HomeController@index')->name('home');
Route::get('/product/{slug}','HomeController@single')->name('product.single');
Route::get('/category/{slug}', 'CategoryController@index')->name('category.single');
Route::get('/store/{slug}', 'StoreController@index')->name('store.single');

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');

    Route::get('remove/{slug}','CartController@remove')->name('remove');
    Route::get('canvcel', 'cartController@cancel')->name('cancel');

});

Route::prefix('checkout')->name('checkout.')->group(function(){

    Route::get('/', 'CheckoutController@index')->name('index');
    Route::post('/process','CheckoutController@process')->name('process');
    Route::get('/thanks', 'CheckoutController@thanks')->name('thanks');
    
    Route::post('/notification', 'CheckoutController@notification')->name('notification');
});

Route::get('my-orders', 'UserOrderController@index')->name('user.orders')->middleware('auth');

Route::group(['middleware'=>['auth', 'access.control.store.admin']], function(){

    //crud lojas
    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){

        Route::get('notifications', 'NotificationController@notifications')->name('notifications.index');
        Route::get('notifications/read-all', 'NotificationController@readAll')->name('notifications.read.all');
        Route::get('notifications/read/{notification}', 'NotificationController@read')->name('notifications.read');

    // Route::prefix('stores')->name('stores.')->group(function(){
    //     Route::get('/', 'StoreController@index')->name('index');
    //     Route::get('/create', 'StoreController@create')->name('create');
    //     Route::post('/store', 'StoreController@store')->name('store');
    //     Route::get('/{store}/edit', 'StoreController@edit')->name('edit');
    //     Route::post('/update/{store}', 'StoreController@update')->name('update');
    //     Route::get('/destroy/{store}', 'StoreController@destroy' )->name('destroy');
    // });


    Route::resource('stores', 'StoreController');
    Route::resource('products', 'ProductController');
    Route::resource('categories', 'CategoryController');

    Route::post('photos/remove', 'ProductPhotoController@removePhoto')->name('photo.remove');

    Route::get('orders/my', 'OrdersController@index')->name('orders.my');
    
});
});


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



Route::get('not', function(){

    $user = \App\User::find(2);
    //$user->notify(new \App\Notifications\StoreReiceveNewOrder());
    return $user->notifications;
});


Route::get('/model', function(){
    //$products = \App\Product::all();  //get (select * from products)

    //$user = new \App\User();            //instancia do model Users

    /*$user= \App\User::find(17);

    $user->name = 'Usuário teste editado';
    $user->save(); */

    //return \App\User::where('name', 'Lucas Vinicios')->get();  //ou first();
    //return return \App\User::paginate(10);    //retirna paginaçã de 10 registros p/ page.


    /* //=================================================================================
    //Mass Assgment

    $user = \App\User::create([
        'name' => 'Lucas vinicios Martins',
        'email' => 'email@teste.com.br',
        'password' => bcrypt('12345678')
    ]);

    
        +*/


        //=================================================================================
        //Update Assgment



       /* $store = \App\Store::find(1);
        return $store->products()->where('id',9)->get(); */

        /*
        //criar uma loja para um usuario
        $user = \App\User::find(10);
        $store = $user->store()->create([
            'name' => 'loja teste',
            'description' => 'loja teste de informática',
            'mobile_phone' => 'xx-xxxx-xxxx',
            'phone' => 'xx-xxxx-xxxx',
            'slug' => 'loja-teste'
        ]);

            dd($store);
            */

        /*
        //criar um produto para uma loja 
        $store = \App\Store::find(41);

        $product = $store->products()->create([
            'name' => 'notebook dell',
        'description' => 'Core 15 8 G',
        'body' => 'qualquer coisa...',
        'price' => 2999.90,
        'slug' => 'notebook-dell'
        ]);

        dd($product);
            */

    /*
        //criar uma categoria
        \App\category::create([
            'name' => 'games',
            'description' => 'games',
            'slug' => 'games'
        ]);

        \App\category::create([
            'name' => 'Notebooks',
            'description' => 'notebooks e computadores',
            'slug' => 'notebooks'
        ]);

        return \App\category::all();
    */


        //adiciona um produto para uma categoria
            $product = \App\Product::find(41);
            dd($product->categories()->sync([1,2]));

        return \App\User::all();
});
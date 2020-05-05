<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Store;
use App\Http\Requests\ProductRequest;
use App\Traits\UploadTrait;

class ProductController extends Controller
{
    use UploadTrait;
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $user = auth()->user();
        
        if(!$user->store()->exists())
        {
            flash('É preciso criar uma loja para exibir produtos')->warning();
            return redirect()->route('admin.stores.index');
        }
        
        $products = $user->store->products()->paginate(10);
        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        $categories = \App\Category::all(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }

    
    public function store(ProductRequest $request) //Product request traz as validaçoes do request
    {
        $images = $request->file('photos');

        foreach($images as $image){
            $image->store('products', 'public');
        }
    
        $data = $request->all();
        $categories = $request->get('categories', null);

        $data['price'] = formatMoneyToDatabase($data['price']);


        $store = auth()->user()->store;
        $product = $store->products()->create($data);
        $product->categories()->sync($categories);

        if($request->hasFile('photos')){
            $images = $this-> imageUpload($request->file('photos'), 'image');
            //inserção dessas imagens a base ( referências das imagens na past)

            $product->photos()->createMany($images);
        }

        flash('Produto criado com sucesso !')->success();
        return redirect()->route('admin.products.index');
    }

    public function show($id)
    {
        
    }

   
    public function edit($product)
    {   
        $product = $this->product->findOrFail($product);
        $categories = \App\Category::all(['id', 'name']);


        return view('admin.products.edit', compact('product', 'categories'));
    }

    
    public function update(ProductRequest $request, $product)
    {
        $data = $request->all();
        $categories = $request->get('categories', null);


        $product = $this->product->find($product);
        $product->update($data);

        if(!is_null($categories))
        $product->categories()->sync($data['categories']);

        if($request->hasFile('photos')){
            $images = $this-> imageUpload($request->file('photos'), 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto atualizado com sucesso !')->success();
        return redirect()->route('admin.products.index');

    }


    public function destroy($product)
    {
        
        $product = $this->product->find($product);
        $product->delete();

        flash('Produto removido com sucesso !')->success();
        return redirect()->route('admin.products.index');
    }


}

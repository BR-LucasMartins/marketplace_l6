<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\session;

class CartController extends Controller
{
    
    public function index(){
        $cart = session()->has('cart') ? session()->get('cart') : [];

        return view('cart', compact('cart'));
    }
    
    
    public function add(Request $request){

        $productData = $request->get('product');
        $product = \App\Product::whereSlug($productData ['slug']);

        if(!$product->count() || $productData['amount'] <= 0) 
            return redirect()->route('product.single', ['slug' => $productData['slug']]);

        $product = array_merge($productData, $product->first(['id','name', 'price', 'store_id'])->toArray());


        //verifica se existe sessão dos produtos
        if(session()->has('cart')){
            
            $products = session()->get('cart');
            $productsSlugs = array_column($products, 'slug');
        

            //caso ja exista um produto no carrinho ao compar outro do mesmo faz apaneas o incremento
            if(in_array($product['slug'], $productsSlugs )){
                $products = $this->productIncrement($product['slug'],$product['amount'],$products);  //passa os 3 parametros p/ função inceremento
                session()->put('cart',$products);
            }
            else{

            //existindo eu adiciono esses produto na sessão existente
            session()->push('cart',$product); //adiciona o produto na sessão ja existente
            }


            
        }
        else{
            //não existindo eu crio essa sessão com o primeiro produto
            $products[] = $product;

            session()->put('cart', $products);  //cria sessão
        }

        flash("produto adicionado no carrinho!")->success();
        return redirect()->route('product.single',['slug'=> $product['slug']]);
    
    }



    //remove o produto do carrinho de compras
    public function remove($slug){

        if(!session()->has('cart')){
            return redirect()->route('cart.index');
        }
        
        $products = session()->get('cart');

        $products = array_filter($products, function($line) use($slug){
            return $line['slug'] != $slug;
        });

        session()->put('cart', $products);
        return redirect()->route('cart.index');
    }


    //função cancelar compra
    public function cancel(){

        session()->forget('cart');  //tira o produto do carrinho pelo metodo forget

        flash("Compra cancelada com sucesso!")->success();
        return redirect()->route('cart.index');
    }

    private function productIncrement($slug, $amount, $products){

        $products = array_map(function($line) use($slug, $amount){
            if($slug == $line['slug']){
                $line['amount'] += $amount;
            }

            return $line;
        },$products );

        return $products;
    }

}

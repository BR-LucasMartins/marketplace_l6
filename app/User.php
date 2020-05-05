<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];



    /*
    não retorna o campo especificado na consulta, (em outras palavras esconde o campo)
    no caso do campo password por questão de segurança ele não pode ser retornado em um select
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /*
    funcao casts permite voce converter o valor de algum campo para um certo tipo de dado primitivo.
    por exemplo retorna um valor float ou boolean  p/ o campo name.
    boolean = true/false
    float = 0; (conversão de string -> float)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        
    ];



    //mapeamento das relações  one-to-one

    // um usuario tem uma loja (hasOne)
    public function store(){

        return $this->hasOne(Store::class);    
    }

    public function orders(){

        return $this->hasMany(UserOrder::class); //usuário pode ter muitos pedidos
    }


   /* public function routeNotificationForNexmo($notification)
    {

        $storemobilePhoneNumber = str_replace(['(', ')', '', '-'], '', $this->store->mobile_phone); //remove os campos(espaços/hífens) da mascara do numero

        return '55'. $storemobilePhoneNumber;  //retirna o numero do telefone formatado
    } */
}

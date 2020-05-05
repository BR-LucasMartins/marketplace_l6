<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Notification;
use Illuminate\Http\Request;
use App\User;
use App\Store;
use App\UserOrder;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    public function index(){

        if(!auth()->check()){
            return redirect()->route('login');
        };


        if(!session()->has('cart')) return redirect()->route('home');
        $this->makePagueSeguroSession();

        $total = 0;
        $cartItems = array_map(function($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));

        $cartItems = array_sum($cartItems);

        return view('checkout', compact('cartItems'));
    }



    public function process(Request $request){

        try {
        $dataPost = $request->all();
        $cartItems = session()->get('cart');
        $stores = array_unique(array_column($cartItems, 'store_id'));
        $reference = Uuid::uuid4();
    
        //Instantiate a new direct payment request, using Credit Card
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL'));

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $creditCard->setReference($reference);

        // Set the currency
        $creditCard->setCurrency("BRL");

        foreach($cartItems as $item){
            // Add an item for this payment request
            $creditCard->addItems()->withParameters(
            $item['id'],
            $item['name'],
            $item['amount'],
            $item['price'],
        );
        }
        

        $user = auth()->user();
        $email = env('PAGSEGURO_ENV')  == 'sandbox' ? 'test@sandbox.pagseguro.com.br' : $user->email;     
        // Set your customer information.
        // If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
        $creditCard->setSender()->setName($user->name);
        $creditCard->setSender()->setEmail($email);

        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '55485772803'
        );

        $creditCard->setSender()->setHash($dataPost['hash']);

        $creditCard->setSender()->setIp('127.0.0.0');

        // Set shipping information for this payment request
        $creditCard->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        //Set billing information for credit card
        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        // Set credit card token
        $creditCard->setToken($dataPost['card_token']);
        list($quantity, $installmentAmount) = explode('|', $dataPost['installment']);

        // Set the installment quantity and value (could be obtained using the Installments
        // service, that have an example here in \public\getInstallments.php)
        $installmentAmount = number_format($installmentAmount, 2, '.', '');
        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount);

        // Set the credit card holder information
        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName($dataPost['card_name']); // Equals in Credit Card

        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '55485772803'
        );

        // Set the Payment Mode for this payment request
        $creditCard->setMode('DEFAULT');

        $result = $creditCard->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        $userOrder = [

            'reference' => $reference,
            'pagseguro_code' => $result->getCode(),
            'pagseguro_status' => $result->getStatus(),
            'items' => serialize($cartItems),
            'store_id' => 42,
        ];

        $userOrder = $user->orders()->create($userOrder);
        $userOrder->stores()->sync($stores);


        //Notificar a loja sobre um novo pedido
            $store = (new Store())->notifyStoreOwners($stores);



        session()->forget('cart');
        session()->forget('pagseguro_session_code');

        return response()->json([

            'data' => [
                'status' => true,
                'message' => 'Pedido criado com sucessso!',
                'order' => $reference
            ]

        ]);
            
        } catch (\Exception $e) {
            
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar pedido';
            return response()->json([

                'data' => [
                    'status' => false,
                    'message' => $message
                ]
    
                ], 401);
        }
    }


    public function thanks(){
        return view('thanks');
    }


    public function notification(){

        try {

            $notification = new Notification();
            
        
            $notification = $notification->getTransaction();

            $reference = base64_decode($notification->getReference());
            
            $userOrder = UserOrder::whereReference($reference);
            $userOrder->update([
                'pagueseguro_status' => $notification->getStatus()
            ]);

            if($notification->getStatus() == 3){

            }

        } catch (\Exception $e) {
            return response()->json([], 204);
        }
    }


    private function makePagueSeguroSession(){

        if(!session()->has('pagseguro_session_code')){
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }
}

<?php

namespace App\Repositories\Orders;

use App\Coupons;
use App\Order;
use App\Restorant as Vendor;
use App\Items;
use App\Tables;
use App\RestoArea;
use App\User;
use Mail;
use Cart;
use App\Models\Variants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Notifications\OrderNotification;
use App\Events\NewOrder as PusherNewOrder;
use App\Events\OrderAcceptedByAdmin;

class BaseOrderRepository extends Controller
{

    /**
     * @var Request request - The request made
     */
    public $request;

    /**
     * @var Vendor vendor - The vendor
     */
    public $vendor;

    /**
     * @var Order order - The order
     */
    public $order;

    /**
     * @var string expedition - Deliver - 1, PickUp -2, Dine in -3
     */
    public $expedition;

    /**
     * @var bool hasPayment
     */
    public $hasPayment;

    /**
     * @var bool isStripe
     */
    public $isStripe;

    /**
     * @var bool status
     */
    public $status=true;

    /**
     * @var bool isNewOrder
     */
    public $isNewOrder=true;

    /**
     * @var string errorMessage - Deliver, DineIn, PickUp
     */
    public $errorMessage="";

    /**
     * @var Redirect paymentRedirect
     */
    public $paymentRedirect=null;

     /**
     * @var bool isMobileOrder
     */
    public $isMobileOrder=false;


    /**
     * @var string redirectLink
     */
    public $redirectLink;

    public function __construct($vendor_id,$request,$expedition,$hasPayment,$isStripe){
        $this->request=$request;
        $this->expedition=$expedition;
        $this->hasPayment=$hasPayment;
        $this->isStripe=$isStripe;

        //Set the Vendor
        $this->vendor = Vendor::findOrFail($vendor_id);
    }

    

    public function constructOrder(){
        //Create the order 
        $this->createOrder();

        //Set Items
        $this->setItems();

        //Set Comment
        $this->setComment();

        //Calculate fees
        $this->calculateFees();

    }

    public function validateOrder(){
        $validator = Validator::make(['order_price'=>$this->order->order_price], [
            'order_price'=>['numeric','min:'.$this->vendor->minimum]
        ]);
        if($validator->fails()){
            $this->invalidateOrder();
        }
        return $validator;
    }

    public function invalidateOrder(){
        $this->status=false;
        $this->order->delete();
    }

    public function updateOrder(){
        //Store it if not stored yet, otherwise update it
        $this->order->update();
    }

    public function finalizeOrder(){
    }

    private function createOrder(){
  

        if($this->order==null){
         
            $this->order=new Order;
            $this->order->restorant_id=$this->vendor->id;
            $this->order->comment="";
            $this->order->payment_method=$this->request->payment_method;
            $this->order->payment_status="unpaid";
            $this->order->tips=$this->request->tips;
            
            //$this->order->checkout_phone_field=$this->request->checkout_phone_field;
            $this->order->checkout_phone_field=$this->request->checkout_phone;
            $this->order->checkout_customer_email_field=$this->request->checkout_customer_email_field;
            $comment=$this->request->comment;

//echo "<pre>";print_r($this->request);die;
            $expeditionsTypes=['delivery'=>1,'pickup'=>2,'dinein'=>3]; //1- delivery 2 - pickup 3-dinein
            $this->order->delivery_method=$expeditionsTypes[$this->expedition];  

            //Client
            if(auth()->user()){
                $this->order->client_id=auth()->user()->id;
            }

            // $this->order->order_price=0;
            // $this->order->vatvalue=0;

            //Save order
            $this->order->save();
            $last_order_id =  $this->order->id;
            $subtotal = $this->request->checkout_subtotal_field;
        
            $last_order =Order::where('id', $last_order_id)->get();
            $table_id =$this->request->dinein_table_id;
            $table_name =Tables::where('id', $table_id)->get();
         
            $restoarea =RestoArea::where('id', $table_name[0]->restoarea_id)->get();

            $restorant= Vendor::where('id',$last_order[0]['restorant_id'])->get();
            $delivery_method= $this->request->delivery_method;
            $tips = $this->request->tips;

            $tips_cal= ($tips/100)*$subtotal;
        
     
            $vat =  $restorant[0]->vat;
            $vatcal = ($subtotal/100) * $vat;
            $netcal= ($subtotal- $vat);
             
            $user= User::where('id', $restorant[0]->user_id)->get();
            $email = $this->request->checkout_customer_email_field;

            $previousOrders = Cookie::get('orders') ? Cookie::get('orders') : '';
            $previousOrderArray = array_filter(explode(',', $previousOrders));
            $orders = Order::whereIn('id', $previousOrderArray)->orderBy('id', 'desc')->get();
           
            $created_at = date('l, F j, Y h:i A',strtotime($last_order[0]['created_at']));

            
        $items= Cart::getContent();
        /*foreach($items as $item){
            echo $item['attributes']['item_comment'];
        }*/
         /*echo "<pre>";
print_r($this->request);
echo "<pre>";*/
          /*print_r($items->toArray());
          die;*/
       

          
        
        $test =[
            'orderid'            =>$last_order[0]->id,
            'subtotal'           =>$subtotal,
            'vat_cal'            =>$vatcal,
            'net_cal'            =>$netcal,
            'payment_method'     =>$last_order[0]->payment_method,
            'payment_status'     =>$last_order[0]->payment_status,
            'restorent_name'     =>$restorant[0]->name,
            'restorent_address'  =>$restorant[0]->address,
            'restorent_phone'    =>$restorant[0]->phone,
            'username'           =>$user[0]->name,
            'useremail'          =>$user[0]->email,
            'tips'               =>$tips_cal,
            'delivery_price'     =>$last_order[0]->delivery_price,
            'discount'           =>$last_order[0]->discount,
            'tablename'          =>$table_name[0]->name,
            'deliverymethod'     =>$delivery_method,
            'restoarea_name'     =>$restoarea[0]->name,
            'items'              =>$items,
            'tip'                =>$tips,
            'vat'                =>$restorant[0]->vat,
            'comment'                =>$comment,
            'created_at'                =>$created_at,
            
           
        ];
       
       
        Mail::send('email.email',$test,function($message) use($test,$email){
                    $message->to($email);
        });

            $this->order->md=md5($this->order->id);
            $this->order->update();

            //Save order custom fields
            $this->order->setMultipleConfig($this->request->customFields);




        }else{
            //Order is already initialized - in case of continues ordering
            $this->isNewOrder=false;
        }
    }
    
    private function setItems(){

        foreach ($this->request->items as $key => $item) {

            
            //Obtain the item
            $theItem = Items::findOrFail($item['id']);

            //List of extras
            $extras = [];
            
            //The price of the item or variant
            $itemSelectedPrice = $theItem->price;

            //Find the variant
            $variantName = '';
            if ($item['variant']) {
                //Find the variant
                $variant = Variants::findOrFail($item['variant']);
                $itemSelectedPrice = $variant->price;
                $variantName = $variant->optionsList;
            }

           //Find the extras
            foreach ($item['extrasSelected'] as $key => $extra) {
                $theExtra = $theItem->extras()->findOrFail($extra['id']);
                $itemSelectedPrice+=$theExtra->price;
                array_push($extras, $theExtra->name.' + '.money($theExtra->price, config('settings.cashier_currency'), config('settings.do_convertion')));
            }
            
            //Total vat on this item
            $totalCalculatedVAT = $item['qty'] * ($theItem->vat > 0?$itemSelectedPrice * ($theItem->vat / 100):0);

            $this->order->items()->attach($item['id'], [
                'qty'=>$item['qty'], 
                'extras'=>json_encode($extras), 
                'vat'=>$theItem->vat, 
                'vatvalue'=>$totalCalculatedVAT, 
                'variant_name'=>$variantName, 
                'variant_price'=>$itemSelectedPrice,
                'item_comment'=>$item['item_comment'], 
            ]);
        } 


        //After we have updated the list of items, we need to update the order price
        $order_price=0;
        $total_order_vat=0;
        foreach ($this->order->items()->get() as $key => $item) {
            $order_price+=$item->pivot->qty*$item->pivot->variant_price;
            $total_order_vat+=$item->pivot->vatvalue;
        }
        $this->order->order_price=$order_price;
        $this->order->vatvalue=$total_order_vat;

        //Set coupons
        if($this->request->has('coupon_code')&&strlen($this->request->coupon_code)>0){
            $coupon = Coupons::where(['code' => $this->request->coupon_code])->where('restaurant_id',$this->vendor->id)->get()->first();
            if($coupon){
                $deduct=$coupon->calculateDeduct($this->order->order_price);
                if($deduct){
                    $coupon->decrement('limit_to_num_uses');
                    $coupon->increment('used_count');
                    $this->order->coupon=$this->request->coupon_code;
                    if($deduct>$this->order->order_price){
                        $this->order->discount=$order_price;

                        //In this case, order should be considered as paid one
                        //$this->order->payment_status = 'paid';
                    }else{
                        $this->order->discount=$deduct;
                    }
                    
                }
            }
        }
        

        //Update the order with the item
        $this->order->update();
    }

    private function setComment(){
       
        $comment = $this->request->comment ? strip_tags($this->request->comment.'') : '';
        $this->order->comment = $this->order->comment.' '.$comment;
        $this->order->update();
    }

    private function calculateFees(){
        $this->order->static_fee=$this->vendor->static_fee;
        $this->order->fee=$this->vendor->fee;
        $this->order->fee_value=($this->vendor->fee/100)*($this->order->order_price_with_discount-$this->vendor->static_fee);
        $this->order->update();
    }

    public function notifyAdmin(){
        //Does nothing
    }

    public function notifyOwner(){
        //Inform owner - via email, sms or db
        $this->vendor->user->notify((new OrderNotification($this->order))->locale(strtolower(config('settings.app_locale'))));

        //Notify owner with pusher
        if (strlen(config('broadcasting.connections.pusher.secret')) > 4) {
            event(new PusherNewOrder($this->order, __('notifications_notification_neworder')));
        }

        //Dispatch Approved by admin event
        OrderAcceptedByAdmin::dispatch($this->order);
    }
}
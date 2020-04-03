<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Region;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Client;
use App\Models\Order;
use App\Models\Contact;

class MainController extends Controller
{
  ////////////////////////////// start general cycle ///////////////

    public function cities()
    {
      $cities = City::all();
      return responseJson(1,'success',$cities);
    }

    public function regions(Request $request)
    {
      $regions = Region::where(function($q) use($request) {

       if($request->has('city_id'))
       {
           $q->where('city_id',$request->city_id);
       }

     })->get();
      return responseJson(1,'success',$regions);
    }

    public function paymentMethod()
    {
      $payment_method = PaymentMethod::all();

      return responseJson(1,'success',$payment_method);
    }

    public function settings()
    {
      $settings = Setting::all();

      return responseJson(1,'success',$settings);
    }


    public function offers()
    {
      $offers = Offer::latest();

      return responseJson(1,'success',$offers);
    }

    public function offerDetails(Request $request)
    {
      $offer = Offer::where('id',$request->offer_id)->get();

      return responseJson(1,'success',$offer);
    }

    public function restaurants()
    {
      $restaurants = Restaurant::all();
      return responseJson(1,'success',$restaurants);
    }

    public function restaurantDetails(Request $request)
    {
      $restaurant = Restaurant::where('id',$request->restaurant_id)->get();

      return responseJson(1,'success',$restaurant);
    }

    public function products(Request $request)
    {
      $products = Product::where('restaurant_id',$request->restaurant_id)->get();
      return responseJson(1,'success',$products);
    }

    public function productDetails(Request $request)
    {
      $product = Product::where('id',$request->product_id)->get();

      return responseJson(1,'success',$product);
    }
    public function categories()
    {
      $categories = Category::all();
      return responseJson(1,'success',$categories);
    }
    public function reviews(Request $request)
    {
      $reviews = Review::where('restaurant_id',$request->restaurant_id)->get();
      $client = $reviews->client()->name;
      dd($client);
      return responseJson(1,'success',['reviews'=>$reviews,'client'=>$client]);
    }

    ////////////////////////////// end general cycle ///////////////


    ////////////////////////////// start restarant food items cycle ///////////////


    public function showProducts(Request $request)
    {
      $restaurant = Product::where('restaurant_id',$request->restaurant_id)->get();

      return responseJson(1,'success',$restaurant);
    }

    public function createProduct(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'restaurant_id'          =>'required',
        'name'                   =>'required',
        'description'            =>'required',
        'price'                  =>'required',
        'offer_price'            =>'required',
        'time_for_prepearing'    =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }
      $product = Product::create($request->all());

      return responseJson(1, 'success', $product);
    }

    public function editProduct(Request $request)
    {

      $product = Product::where('id',$request->product_id)->first();

      $product->update($request->all());

      return responseJson(1, 'success', $product);
    }

    public function deleteProduct(Request $request)
    {

      $product = Product::where('id',$request->product_id)->first();

      $product->delete();

      return responseJson(1, 'success');
    }


    ////////////////////////////// end restarant food items cycle ///////////////


    ////////////////////////////// start restarant offers cycle ///////////////


    public function showOffers(Request $request)
    {
      $Offers = Offer::where('restaurant_id',$request->restaurant_id)->get();

      return responseJson(1,'success',$Offers);
    }

    public function createOffer(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'restaurant_id'          =>'required',
        'title'                   =>'required',
        'details'            =>'required',
        'from'                  =>'required',
        'to'            =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }
      $offer = Offer::create($request->all());

      return responseJson(1, 'success', $offer);
    }

    public function editOffer(Request $request)
    {

      $offer = Offer::where('id',$request->offer_id)->first();

      $offer->update($request->all());

      return responseJson(1, 'success', $offer);
    }

    public function deleteOffer(Request $request)
    {

      $offer = Offer::where('id',$request->offer_id)->first();

      $offer->delete();

      return responseJson(1, 'success');
    }


    ////////////////////////////// end restarant offers cycle ///////////////


    ////////////////////////////// start client order cycle ///////////////



    public function newOrder(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'restaurant_id'                  =>'required|exists:restaurants,id',
        'products.*.product_id'          =>'required|exists:products,id',
        'products.*.quantity'          =>'required',
        'address'                   =>'required',
        'payment_method_id'            =>'required',

        'api_token'              =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }
      $restaurant = Restaurant::find($request->restaurant_id);

      if($restaurant->available == 'close')
      {
        return responseJson(0, 'هذا المطعم مغلق');
      }

      $order = $request->user()->orders()->create([

        'restaurant_id'     => $request->restaurant_id,
        'special_order'     => $request->special_order,
        'status'            =>'pending',
        'address'           => $request->address,
        'payment_method_id' => $request->payment_method_id,

      ]);

      $cost =0;
      $delivery_charge =   $restaurant->delivery_charge;

      foreach ($request->products as $p) {

        $product = Product::find($p['product_id']);
        $readyProduct = [
          $p['product_id'] => [
            'quantity' => $p['quantity'],
            'price' => $product->price,
            'notes' => (isset($p['notes'])) ? $p['notes'] : '',
          ]
        ];
        $order->products()->attach($readyProduct);
        $cost += ($product->price * $p['quantity']);

      }

      if($cost >= $restaurant->minimum_order)
      {
        $total = $cost+$delivery_charge;
        $commission = Setting::first()->commission * $cost;
        $net = $total - $commission;

        $update = $order->update([
          'cost' => $cost,
          'delivery_cost' => $delivery_charge,
          'total' => $total,
          'commission' => $commission,
          'net' => $net,

        ]);

      }
      else
      {
        $order->products()->delete();
        $order->delete();
        return responseJson(0,'لايمكن أن يكون الطلب أقل من'.$restaurant->minimum_order.'جنيه');
      }

      $notification = $restaurant->notifications()->create(
        [
          'title'=>'يوجد طلب جديد',
          'content'=>$request->user()->name .'لديك طلب جديد من العميل',
          // 'notificationable_id' =>$restaurant->id,
          // 'notificationable_type' =>'restaurant',
          // 'order_id' =>$order->id
        ]
      );
      // dd($notification);
      $tokens = $restaurant->tokens()->where('token','!=', null)->pluck('token')->toArray();

      if (count($tokens))
     {
       $title = $notification->title;
       $body = $notification->content;
       $data =[
         'notification'=> $notification
       ];
       $send = notifyByFirebase($title,$body,$tokens,$data);
     }

     return responseJson(1,'تم',$send);

     // dd($tokens);

    }


    public function orderDetails(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'order_id'              =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }
      $order = Order::where('id',$request->order_id)->first();
      // $restaurant = $order->restaurant->name;

      return responseJson(1, 'success', [
        'order' => $order,
        //'restaurant' => $restaurant,
        ]);
    }

    public function myOrders(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'status'              =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      if($request->status == 'accepted')
      {
        $orders = Order::where('status','accepted')->get();

          return responseJson(1, 'success', $orders );
      }

      if($request->status == 'deliverd' || $request->status == 'rejected' || $request->status == 'declined' )
      {
        $orders = Order::where('status','deliverd')->orWhere('status','rejected')->orWhere('status','declined')->get();

          return responseJson(1, 'success', $orders );
      }

      else
      {
        return responseJson(0, 'خطأ');
      }

    }

    public function clientAcceptedOrder(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'order_id'               =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $order = Order::where('id',$request->order_id)->first();
      $restaurant = $order->restaurant()->first();
      $notification = $restaurant->notifications()->create(
        [
          'title'=>'تم استلام الطلب',
          'content'=>$request->user()->name .'تم استلام العميل للطلب',

        ]
      );
      // dd($notification);
      // dd($notification);
      $tokens = $restaurant->tokens()->where('token','!=', null)->pluck('token')->toArray();

      if (count($tokens))
     {
       $title = $notification->title;
       $body = $notification->content;
       $data =[
         'order'=> $order
       ];
       $send = notifyByFirebase($title,$body,$tokens,$data);
    }
  }


    public function clientDeclinedOrder(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'order_id'               =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $order = Order::where('id',$request->order_id)->first();
      $order->update(['status' => 'declined']);
      $restaurant = $order->restaurant()->first();
      $notification = $restaurant->notifications()->create(
        [
          'title'=>'تم استلام الطلب',
          'content'=>$request->user()->name .'تم استلام العميل للطلب',

        ]
      );
      // dd($notification);
      // dd($notification);
      $tokens = $restaurant->tokens()->where('token','!=', null)->pluck('token')->toArray();

      if (count($tokens))
     {
       $title = $notification->title;
       $body = $notification->content;
       $data =[
         'order'=> $order
       ];
       $send = notifyByFirebase($title,$body,$tokens,$data);
    }
  }

    ////////////////////////////// end client order cycle ///////////////




    ////////////////////////////// start restaurant order cycle ///////////////


    public function restaurantOrders(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'status'              =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      if($request->status == 'pending')
      {
        $orders = Order::where('status','pending')->get();

          return responseJson(1, 'success', $orders );
      }

      if($request->status == 'accepted')
      {
        $orders = Order::where('status','accepted')->get();

          return responseJson(1, 'success', $orders );
      }

      if($request->status == 'deliverd' || $request->status == 'rejected' || $request->status == 'declined' )
      {
        $orders = Order::where('status','deliverd')->orWhere('status','rejected')->orWhere('status','declined')->get();

          return responseJson(1, 'success', $orders );
      }

      else
      {
        return responseJson(0, 'خطأ');
      }

    }


    public function restaurantConfirmOrder(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'order_id'               =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $order = Order::where('id',$request->order_id)->first();
      $order->update(['status' => 'deliverd']);

      return responseJson(1, 'success', $order );

    }

    public function restaurantAcceptedOrder(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'order_id'               =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $order = Order::where('id',$request->order_id)->first();
      $order->update(['status' => 'accepted']);
      $client = $order->restaurant()->first();
      $notification = $client->notifications()->create(
        [
          'title'=>'تم الغاء الطلب',
          'content'=>$request->user()->name .'تم الغاء الطلب من مطعم  ',

        ]
      );
      // dd($notification);
      // dd($notification);
      $tokens = $client->tokens()->where('token','!=', null)->pluck('token')->toArray();

      if (count($tokens))
     {
       $title = $notification->title;
       $body = $notification->content;
       $data =[
         'order'=> $order
       ];
       $send = notifyByFirebase($title,$body,$tokens,$data);
    }

    }


    public function restaurantRejectedOrder(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'api_token'              =>'required',
        'order_id'               =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $order = Order::where('id',$request->order_id)->first();
      $order->update(['status' => 'rejected']);
      $client = $order->restaurant()->first();
      $notification = $client->notifications()->create(
        [
          'title'=>'تم الغاء الطلب',
          'content'=>$request->user()->name .'تم الغاء الطلب من مطعم  ',

        ]
      );
      // dd($notification);
      // dd($notification);
      $tokens = $client->tokens()->where('token','!=', null)->pluck('token')->toArray();

      if (count($tokens))
     {
       $title = $notification->title;
       $body = $notification->content;
       $data =[
         'order'=> $order
       ];
       $send = notifyByFirebase($title,$body,$tokens,$data);
    }
  }



    ////////////////////////////// end restaurant order cycle ///////////////




    public function contactUs(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'name'            =>'required',
        'email'            =>'required',
        'phone'            =>'required',
        'type_of_message'  =>'required',
        'message'          =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $contact = Contact::create($request->all());
      return responseJson(1, 'success', $contact );

    }

    public function createReview(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'react'          =>'required',
        'comment'        =>'required',
        'restaurant_id'  =>'required',
        'api_token'      =>'required',

      ]);

      if($validator->fails())
      {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
      }

      $review = $request->user()->reviews()->create($request->all());
      return responseJson(1, 'success', $review );

    }




}

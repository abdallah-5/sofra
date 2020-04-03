<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;




use App\Models\Client;
use App\Models\Restaurant;
use App\Models\Token;
use Auth;

class AuthController extends Controller
{


    ////////////////////////////// start Auth client cycle ///////////////

    public function clientRegisterToken(Request $request)
    {
      $validator = validator()->make($request->all(), [

        'token'             =>'required',
        'type'             =>'required|in:android,ios'

      ]);

      if($validator->fails())
      {
        return responseJeson(0, $validator->errors()->first(), $validator->errors());
      }

      Token::where('token',$request->token)->delete();
      $request->user()->tokens()->create($request->all());
      // Token::create([
      //   'token' => $request->token,
      //   'type' => $request->type,
      //   'tokenable_id' => 1,//$request->user()->id,//auth()->guard('client')->id,
      //   'tokenable_type' => 'client',
      //
      // ]);
      return responseJson(1,'تم تسجيل الجهاز بنجاح');
    }

    ////////////////////////////// end registerToken ///////////////


    ////////////////////////////// start removeToken ///////////////

    public function clientRemoveToken(Request $request)
    {
      $validator = validator()->make($request->all(), [

      'token'             =>'required',

    ]);

    if($validator->fails())
    {
      return responseJeson(0, $validator->errors()->first(), $validator->errors());
    }

    Token::where('token',$request->token)->delete();
    return responseJson(1,'تم الحذف بنجاح');
    }

  public function clientRegister(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'name'              =>'required',
      'password'          =>'required|confirmed',
      'phone'             =>'required|unique:clients',
      'email'             =>'required|unique:clients',
      'region_id'           =>'required',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }
    $request->merge(['password' => bcrypt($request->password)]);
    $client = Client::create($request->all());
    $client->api_token = Str::random(60);
    $client->save();

    return responseJson(1, 'success',[
      'api_token' => $client->api_token,
      'client' => $client
    ]);
  }

  public function clientLogin(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'email'             =>'required',
      'password'          =>'required',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }
    $client = Client::where('email',$request->email)->first();
    if($client){
      if(Hash::check($request->password, $client->password))
      {
        return responseJson(1,'logged',[
          'api_token'=> $client->api_token,
          'client'=> $client
        ]);
      }
      else{
            return responseJson(0,'البيانات غير صحيحة');
      }
    }
    else {
          return responseJson(0,'البيانات غير صحيحة');
    }

  }


  public function clientResetPassword(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'phone'             =>'required',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }
    $client = Client::where('phone',$request->phone)->first();

    if($client)
    {
      $code = rand(1111,9999);
      $update = $client->update(['pin_code' => $code]);

      if($update)
      {
        Mail::to($client->email)
          ->bcc("abdalah.learn@gmail.com")
          ->send(new ResetPassword($client));

        return responseJson(1, 'برجاء فحص الحساب', ['pin_code_for_reset' => $code]);
      }

      else
      {
        return responseJson(0, 'حدث خطأ حاول مرة أخرى');
      }

    }

    else
    {
      return responseJson(0, 'لايوجد حساب لهذا الرقم');
    }

  }

  public function clientNewPassword(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'pin_code'                 =>'required',
      'password'             =>'required|confirmed',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }

    $client = Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();
    if($client)
    {

      $client->password = bcrypt($request->password);
      $client->pin_code = null;
      // dd($client->pin_code);

      if($client->save())
      {
        return responseJson(1, 'تم تغيير كلمة المرور بنجاح');
      }

      else
      {
        return responseJson(0, 'حدث خطأ حاول مرة أخرى');
      }
    }

    else
    {
      return responseJson(0, 'هذا الكود غير صالح');
    }

  }



  public function clientProfile(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'email' => 'unique:clients,email,'.$request->user()->id
    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }


    $profile = $request->user();
    $profile->update($request->all());
    return responseJson(1,'success',$profile);
  }

  ////////////////////////////// end Auth client cycle ///////////////


  ////////////////////////////// start Auth restaurant cycle ///////////////

  public function restaurantRegisterToken(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'token'             =>'required',
      'type'             =>'required|in:android,ios'

    ]);

    if($validator->fails())
    {
      return responseJeson(0, $validator->errors()->first(), $validator->errors());
    }

    Token::where('token',$request->token)->delete();
    $request->user()->tokens()->create($request->all());

    return responseJson(1,'تم تسجيل الجهاز بنجاح');
  }

  ////////////////////////////// end registerToken ///////////////


  ////////////////////////////// start removeToken ///////////////

  public function restaurantRemoveToken(Request $request)
  {
    $validator = validator()->make($request->all(), [

    'token'             =>'required',

  ]);

  if($validator->fails())
  {
    return responseJeson(0, $validator->errors()->first(), $validator->errors());
  }

  Token::where('token',$request->token)->delete();
  return responseJson(1,'تم الحذف بنجاح');
  }
  public function restaurantRegister(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'name'              =>'required',
      'password'          =>'required|confirmed',
      'phone'             =>'required|unique:restaurants',
      'email'             =>'required|unique:restaurants',
      'region_id'           =>'required',
      'whatsapp'           =>'required|unique:restaurants',
      'contact_phone'           =>'required|unique:restaurants',
      'minimum_order'           =>'required',
      'delivery_charge'           =>'required',
      'category_id'           =>'required',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }
    $request->merge(['password' => bcrypt($request->password)]);
    $restaurant = Restaurant::create($request->all());
    $restaurant->api_token = Str::random(60);
    $restaurant->save();

    return responseJson(1, 'success',[
      'api_token' => $restaurant->api_token,
      'retaurant' => $restaurant
    ]);
  }


  public function restaurantLogin(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'email'             =>'required',
      'password'          =>'required',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }
    $restaurant = Restaurant::where('email',$request->email)->first();
    if($restaurant){
      if(Hash::check($request->password, $restaurant->password))
      {
        return responseJson(1,'logged',[
          'api_token'=> $restaurant->api_token,
          'restaurant'=> $restaurant
        ]);
      }
      else{
        return responseJson(0,'البيانات غير صحيحة');
      }
    }
    else {
      return responseJson(0,'البيانات غير صحيحة');
    }

  }

  public function restaurantProfile(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'email' => 'unique:clients,email,'.$request->user()->id
    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }


    $profile = $request->user();
    $profile->update($request->all());
    return responseJson(1,'success',$profile);
  }


  public function restaurantResetPassword(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'phone'             =>'required',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }
    $restaurant = Restaurant::where('phone',$request->phone)->first();

    if($restaurant)
    {
      $code = rand(1111,9999);
      $update = $restaurant->update(['pin_code' => $code]);

      if($update)
      {
        Mail::to($restaurant->email)
        ->bcc("abdalah.learn@gmail.com")
        ->send(new ResetPassword($restaurant));

        return responseJson(1, 'برجاء فحص الحساب', ['pin_code_for_reset' => $code]);
      }

      else
      {
        return responseJson(0, 'حدث خطأ حاول مرة أخرى');
      }

    }

    else
    {
      return responseJson(0, 'لايوجد حساب لهذا الرقم');
    }

  }


  public function restaurantNewPassword(Request $request)
  {
    $validator = validator()->make($request->all(), [

      'pin_code'                 =>'required',
      'password'             =>'required|confirmed',

    ]);

    if($validator->fails())
    {
      return responseJson(0, $validator->errors()->first(), $validator->errors());
    }

    $restaurant = Restaurant::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();
    if($restaurant)
    {

      $restaurant->password = bcrypt($request->password);
      $restaurant->pin_code = null;
      // dd($client->pin_code);

      if($restaurant->save())
      {
        return responseJson(1, 'تم تغيير كلمة المرور بنجاح');
      }

      else
      {
        return responseJson(0, 'حدث خطأ حاول مرة أخرى');
      }
    }

    else
    {
      return responseJson(0, 'هذا الكود غير صالح');
    }

  }

  ////////////////////////////// end Auth restaurant cycle ///////////////



}

<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

function getCategories()
{
    return Category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->orderBy('id', 'DESC')
        ->where('status', 1)
        ->where('showHome', 'Yes')
        ->get();
}


function getProductImage($productId) {
    ProductImage::where('product_id', $productId)->first();
}

function OrderEmail($orderId, $userType="customer"){
    $order = Order::where('id',$orderId)->with('items')->first();

    if($userType == 'customer'){
        $subject = 'Thanks For Your Order';
        $email = $order->email;
    }else{
        $subject = 'You Have Recieved An Order';
        $email = env('ADMIN_EMAIL');
    }


    $mailData = [
        'subject' => 'Thanks For Your Order',
        'order' => $order,
        'userType' => $userType
    ];






    Mail::to($email)->send(new OrderEmail($mailData));
    // dd($order);

}


function getCountryInfo($id){
   return Country::where('id',$id)->first();

}

function staticPages(){
    $pages = Page::orderBy('name','ASC')->get();
    return $pages;
}

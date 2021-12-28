<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Auth;
use Carbon\Carbon; 

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class CashController extends Controller
{
   
    

    public function CashOrder(Request $request){

		$id = Auth::id();

		$user = User::where('id',$id)->first();

		if ($user->email_verified_at == NULL){

			$notification = array(
				'message' => 'At First Verify Your E-mail',
				'alert-type' => 'error'
			);
	
			return redirect()->route('dashboard')->with($notification);

		}else{



    	if (Session::has('coupon')) {
    		$total_amount = Session::get('coupon')['total_amount'];
    	}else{
    		$total_amount = round(Cart::total());
    	}



	  // dd($charge);

     $order_id = Order::insertGetId([
     	'user_id' => Auth::id(),
     	'division_id' => $request->division_id,
     	'district_id' => $request->district_id,
     	'state_id' => $request->state_id,
     	'name' => $request->name,
     	'email' => $request->email,
     	'phone' => $request->phone,
		 'village' => $request->village,
     	'post_code' => $request->post_code,
     	'notes' => $request->notes,

     	'payment_type' => 'Cash On Delivery',
     	'payment_method' => 'Cash On Delivery',

     	'currency' =>  'Usd',
     	'amount' => $total_amount,


     	'invoice_no' => 'EOS'.mt_rand(10000000,99999999),
     	'order_date' => Carbon::now()->format('d F Y'),
     	'order_month' => Carbon::now()->format('F'),
     	'order_year' => Carbon::now()->format('Y'),
     	'status' => 'pending',
     	'created_at' => Carbon::now(),	 

     ]);

     // Start Send Email 
     $invoice = Order::findOrFail($order_id);
     	$data = [
     		'invoice_no' => $invoice->invoice_no,
     		'amount' => $total_amount,
     		'name' => $invoice->name,
     	    'email' => $invoice->email,
     	];

     	






		 $user_gmail = $user->email;
		 $order = $data;


//Load Composer's autoloader
require 'D:\xampp2\htdocs\laravel\new_ecom\vendor\autoload.php';


$mail = new PHPMailer(true);

try {

   //Server settings

   $mail->SMTPDebug = NULL;                      
   $mail->isSMTP();                                           
   $mail->Host       = 'smtp.gmail.com';                    
   $mail->SMTPAuth   = true;                                  
   $mail->Username   = 'arfiniqbal8@gmail.com';                     
   $mail->Password   = '92155510';                              
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
   $mail->Port       = 465;                                   

  
   $mail->setFrom('arfiniqbal8@gmail.com');
   $mail->addAddress($user_gmail);    

   

	

 
   $mail->isHTML(true);                                
   $mail->Subject = 'Tech Hive It';
   $mail->Body    = view('mail.order_mail',compact('order'));
   $mail->AltBody = 'Tech Hive It';

   $mail->send();

} catch (Exception $e) {
   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}





























		

	 










     // End Send Email 


     $carts = Cart::content();
     foreach ($carts as $cart) {
     	OrderItem::insert([
     		'order_id' => $order_id, 
     		'product_id' => $cart->id,
     		'color' => $cart->options->color,
     		'size' => $cart->options->size,
     		'qty' => $cart->qty,
     		'price' => $cart->price,
     		'created_at' => Carbon::now(),

     	]);
     }


     if (Session::has('coupon')) {
     	Session::forget('coupon');
     }

     Cart::destroy();

     $notification = array(
			'message' => 'Your Order Place Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('dashboard')->with($notification);


    }  


	}// end method



}

<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

function paginate($data)
{
    $collection = collect($data['meta']);
    $data = $collection->put('data', $data['data']);
    return $data;
}

function saveFile(Illuminate\Http\UploadedFile $file, String $subFolder, String $disk = 'local')
{
    $extension = $file->getClientOriginalExtension();
    $fileName = time() . rand(1000, 9999) . '.' . $extension;
    $fileSize = $file->getSize();
    $fileType = $file->getMimeType();

    $sanitizedName = str_replace($extension, '', Illuminate\Support\Str::slug($file->getClientOriginalName()));

    if ($disk == "s3") {
        $path = $subFolder . '/' . $fileName . '.' . $extension;
        \Illuminate\Support\Facades\Storage::disk('s3')->put($path, file_get_contents($file));
    } else {
        if (!File::exists(public_path($subFolder))) {
            File::makeDirectory(public_path($subFolder), 777, true, true);
        }
        $file->move(public_path($subFolder), $fileName);
        $path = "{$subFolder}/{$fileName}";
    }

    return [
        "name" => $fileName,
        "extension" => $extension,
        "fileSize" => $fileSize,
        "fileType" => $fileType,
        "path" => $path,
        "disk" => $disk
    ];
}

function createPaymentMethod(Request $request) {
    try {
       $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
       $paymentMethod = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $request->card_number,
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'cvc' => $request->cvc,
            ],
          ]);
       return $paymentMethod;

    } catch (Exception $e) {
       return $e->getMessage(); 
    }  
}

function createCustomerAndAttachPaymentMethod($paymentMethod) {

    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    
    $customer =  $stripe->customers->create([
      'description' => auth()->user()->name .'description',
      'payment_method' => $paymentMethod
    ]);


    return $customer;
}

function addMonthToCurrenctDate($duration) {
    return now()->addMonth($duration)->toDateString();
}


function sentFCMNotification($deviceToken, $title, $body, $page = '') {
    $serverKey = 'AAAAGzQs2Ck:APA91bFEvlQnkCQGjuOX3-TR5k56ph2Xbdps9R9cSVqmxjdIkEoRWWEv_ju41caaeo302pxWoMQNasvWJsSG6cdp-aOT0HyAQMhL6uw2qZ5LvUKuQLjV0Uy7OWlIGTm2mFsl64dEWQkZ'; // Replace with your FCM Server Key
    $url = 'https://fcm.googleapis.com/fcm/send';

    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $data = [
        'to' => $deviceToken,
        'notification' => [
            'title' => $title,
            'body' => $body,
        ],
        'data' => [
            'page_reference' => $page,
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only for local development, remove for production
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    // Handle the response if needed
    return $response;

}




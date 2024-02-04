<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function encrypt($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    public function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    public function pkcs5_pad($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    public function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }

    public function ResponseHendaler(Request $request)
    {
        error_reporting(0);
        $workingKey = '03F537024406DBB9A64FC2B74F029DB1'; //Working Key should be provided here.
        $encResponse = $request->encResp; //This is the response sent by the CCAvenue Server
        $rcvdString = $this->decrypt($encResponse, $workingKey); //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);

        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3) {
                $order_status = $information[1];
            }
        }

        if ($order_status === "Success") {
            $data = [];
            $transaction_id = explode('=', $decryptValues[2]);
            $data['transaction_id'] = $transaction_id[1];

            $status = explode('=', $decryptValues[3]);
            $data['status']= $status[1];

            $amount = explode('=', $decryptValues[10]);
            $data['amount'] = $amount[1];



            $document_no = explode('=', $decryptValues[27]);
            $data['document_no'] = $document_no[1];

            $user_id = explode('=', $decryptValues[26]);
            $data['user_id'] = $user_id[1];
            $plan = UserPlan::create($data);
            $user = User::find($plan->user_id);
            $user->remain_doc = $user->remain_doc + $plan->document_no;
            $date = Carbon::now();
            $date->addDays(180);
            $user->exp_date = $date;
            $user->save();
            return redirect()->to('http://localhost:4200/payment-success/'.encrypt($plan->id));

        } else if ($order_status === "Aborted") {
            return redirect()->to('http://localhost:4200/payment-failed');

        } else if ($order_status === "Failure") {
            return redirect()->to('http://localhost:4200/payment-failed');
        } else {
            return redirect()->to('http://localhost:4200/payment-failed');

        }
    }

    public function requesthandaler(Request $request)
    {
        // return $request->all();
        error_reporting(0);

        $merchant_data = '';
        $working_key = '03F537024406DBB9A64FC2B74F029DB1'; //Shared by CCAVENUES
        $access_code = 'AVBZ40KL17BA58ZBAB'; //Shared by CCAVENUES
        $random = rand(000000, 999999);
        $data = [
            'merchant_id' => 3096749,
            'order_id' => $random,
            'amount' => $request->price,
            'currency' => 'INR',
            'language' => 'EN',
            'merchant_param1' => $request->user_id,
            'merchant_param2' => $request->document_no,
            'redirect_url' => 'http://127.0.0.1:8000/api/payment/status',
            'cancel_url' => 'http://127.0.0.1:8000/api/payment/status',
        ];
        // return response()->json(['success' => true, 'data' =>$data ], 200);

        foreach ($data as $key => $value) {
            $merchant_data .= $key . '=' . $value . '&';
        }
        $encrypted_data = $this->encrypt($merchant_data, $working_key);
        return response()->json(['success' => true, 'encrypted_data' => $encrypted_data, 'access_code' => $access_code], 200);
    }
}

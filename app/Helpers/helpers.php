<?php

use App\Models\GeneralSettings;

function get_settings($key){
  
  $value = GeneralSettings::where('key', $key)->first()?->value;

  return $value;
}

function generateNowPaymentsAddress($amount, $currency, $code){
  $nowPaymentsApiKey = get_settings('nowpayments_api_key');
    $response       = curlPostContent('https://api.nowpayments.io/v1/invoice', json_encode([
        'price_amount'     => $amount,
        'price_currency'   => "usd",
        //"pay_currency" => "usdttrc20",
        'ipn_callback_url' => route('deposit.ipn'),
        'success_url'=> route('deposit.success'),
        'cancel_url'=> route('deposit.cancel'),
        'order_id'         => $code,

    ]), [
        "x-api-key: $nowPaymentsApiKey",
        'Content-Type: application/json',
    ]);
     $response = json_decode($response);

    if (!$response) {
        $send['redirect']   = false;
        $send['message'] = 'Some problem ocurred with api.';
        return $send;
    }

    if(!@$response->invoice_url){
        $send['redirect']   = false;
        $send['message'] = 'Invalid api key';
        return json_encode($send);
    }

    $send['redirect'] = true;
    $send['redirect_url'] = $response->invoice_url;

    return $send;
}

function curlPostContent($url, $postData = null, $header = null)
{
    if (is_array($postData)) {
        $params = http_build_query($postData);
    } else {
        $params = $postData;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if ($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (!function_exists('generate_uuid')) {
    /**
     * @return string uniquid()
     * return string generate_uuid()
     */
    function generate_uuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
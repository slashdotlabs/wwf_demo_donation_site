<?php


namespace App\Billing;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpayGateway
{
    protected $api_base_url = "https://apis.ipayafrica.com";
    protected $vendor_id = "demo";
    protected $hashkey = "demoCHANGED";

    public function charge($meta_data)
    {
        $ipay_base_url = "https://payments.ipayafrica.com/v3/ke";
        $fields = collect([
            "live" => 0,
            "oid" => $meta_data['order_id'],
            "inv" => null,
            "ttl" => $meta_data['amount'],
            "tel" => $meta_data['phone_number'],
            "eml" => $meta_data['email'],
            "vid" => $this->vendor_id,
            "curr" => "KES",
            "p1" => "KES",
            "p2" => "",
            "p3" => "",
            "p4" => "",
            "cbk" => url("payment/process"),
            "cst" => "1",
            "crl" => "0"
        ]);

        $generated_hash = $this->generate_hash($fields, 'sha1');
        $fields->put('hsh', $generated_hash);

        // url encode callback
        $fields->put('cbk', urlencode($fields->get('cbk')));

        $fields_string = $fields->map(function ($value, $key) {
            return $key.'='.$value;
        })->join('&');

        return redirect($ipay_base_url.'?'.$fields_string);
    }

    public function rest_initiate_request(array $params)
    {
        $url = $this->api_base_url . "/payments/v2/transact";
        $fields = collect([
            'live' => 0,
            'oid' => $params['order_id'],
            "inv" => $params['order_id'],
            'amount' => $params['amount'],
            'tel' => $params['phone_number'],
            'eml' => $params['email'],
            'vid' => $this->vendor_id,
            'curr' => 'KES',
            "p1" => "",
            "p2" => "",
            "p3" => "",
            "p4" => "",
            'cst' => 1,
            'cbk' => "https://cf16777b.ngrok.io/payment/process",
        ]);

        $generated_hash = $this->generate_hash($fields, 'sha256');
        $fields->put('hash', $generated_hash);
        return Http::post($url, $fields->toArray());
    }

    private function generate_hash(Collection $fields, string $algo): string
    {
        // datastring
        $datastring = $fields->join("");
        // generate hash
        return hash_hmac($algo, $datastring, $this->hashkey);
    }

    public function processs_initiator_response(array $response)
    {
        //  billing_transactions: update sid and account
        // TODO: ??? perhaps validate the response has ???

        // charge either mobile or credit card
    }

    public function trigger_stk_push(string $phone_number, string $sid)
    {
        $url = $this->api_base_url . "/payments/v2/transact/push/mpesa";
        $fields = collect([
            'phone' => $phone_number,
            'vid' => $this->vendor_id,
            'sid' => $sid
        ]);

        $generated_hash = $this->generate_hash($fields, 'sha256');
        $fields->put('hash', $generated_hash);

        return Http::post($url, $fields->toArray());
    }

    public function recurring_billing(array $params)
    {
        $url = $this->api_base_url . "/payments/v2/transact/cc/recurring";
        $fields = collect([
            'sid' => $params['sid'],
            'vid' => $this->vendor_id,
            'cardid' => $params['cardid'],
            'phone' => $params['phone'],
            'email' => $params['email'],
        ]);

        $generated_hash = $this->generate_hash($fields, 'sha256');
        $fields->put('hash', $generated_hash);

        return Http::post($url, $fields->toArray());

        // TODO: process like normal payment
    }

    public function get_status_state($code)
    {
        $code_reference = [
            'fe2707etr5s4wq' => [
                'state' => 'Failed transaction',
                'process' => false
            ],
            'aei7p7yrx4ae34' => [
                'state' => 'Success',
                'process' => true
            ],
            'bdi6p2yy76etrs' => [
                'state' => 'Pending: Incoming Mobile Money Transaction Not found. Please try again in 5 minutes.',
                'process' => false
            ],
            'cr5i3pgy9867e1' => [
                'state' => 'This code has been used already. A notification of this transaction sent to the merchant.',
                'process' => false
            ],
            'dtfi4p7yty45wq' => [
                'state' => 'The amount that you have sent via mobile money is LESS than what was required to validate this transaction.',
                'process' => false
            ],
            'eq3i7p5yt7645e' => [
                'state' => 'The amount that you have sent via mobile money is MORE than what was required to validate this transaction.',
                'process' => false
            ],
        ];
        return $code_reference[$code] ?? false;
    }
}

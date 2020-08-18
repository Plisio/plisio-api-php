<?php

namespace Plisio;

class ClientAPI
{
    protected $secretKey = '';
    public $apiEndPoint = 'https://plisio.net/api/v1';


    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    protected function getApiUrl($commandUrl)
    {
        return trim($this->apiEndPoint, '/') . '/' . $commandUrl;
    }

    public function getBalances($currency)
    {
        return $this->apiCall('balances', array('currency' => $currency));
    }

    public function getCurrencies()
    {
        return $this->guestApiCall('currencies');
    }

    public function createTransaction($req)
    {
        return $this->apiCall('invoices/new', $req);
    }


    /**
     * Creates a withdrawal from your account to a specified address.<br />
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param address The address to send the coins to.
     * @param auto_confirm If auto_confirm is TRUE, then the withdrawal will be performed without an email confirmation.
     */
    public function createWithdrawal($amount, $currency, $address)
    {
        $req = array(
            'currency' => $currency,
            'amount' => $amount,
            'to' => $address,
            'type' => 'cash_out',
        );
        return $this->apiCall('operations/withdraw', $req);
    }

    /**
     * Creates a withdrawal from your account to a specified address.<br />
     * @param payments array of addresses and amounts.
     * @param currency The cryptocurrency to withdraw.
     */
    public function createMassWithdrawal($payments, $currency)
    {
        $req = array(
            'currency' => $currency,
            'amount' => implode(',', array_values($payments)),
            'to' => implode(',', array_keys($payments)),
            'type' => 'mass_cash_out',
        );
        return $this->apiCall('operations/withdraw', $req);
    }


    private function isSetup()
    {
        return !empty($this->secretKey);
    }

    protected function getCurlOptions($url)
    {
        return [
            CURLOPT_URL => $url,
            CURLOPT_HTTPGET => true,
            CURLOPT_FAILONERROR => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ];
    }

    private function apiCall($cmd, $req = array())
    {
        if (!$this->isSetup()) {
            return array('error' => 'You have not called the Setup function with your private and public keys!');
        }
        return $this->guestApiCall($cmd, $req);
    }

    private function guestApiCall($cmd, $req = array())
    {
        // Generate the query string
        $queryString = '';
        if (!empty($this->secretKey)) {
            $req['api_key'] = $this->secretKey;
        }
        if (!empty($req)) {
            $post_data = http_build_query($req, '', '&');
            $queryString = '?' . $post_data;
        }

        try {
            $apiUrl = $this->getApiUrl($cmd . $queryString);

            $ch = curl_init();
            curl_setopt_array($ch, $this->getCurlOptions($apiUrl));
            $data = curl_exec($ch);

            if ($data !== FALSE) {
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $body = substr($data, $header_size);
                $dec = $this->jsonDecode($body);
                if ($dec !== NULL && count($dec)) {
                    return $dec;
                } else {
                    // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                    return array('status' => 'error', 'message' => 'Unable to parse JSON result (' . json_last_error() . ')');
                }
            } else {
                return array('status' => 'error', 'message' => 'cURL error: ' . curl_error($ch));
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => 'Could not send request to API : ' . $apiUrl);
        }
    }

    private function jsonDecode($data)
    {
        if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
            // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
            $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
        } else {
            $dec = json_decode($data, TRUE);
        }
        return $dec;
    }

    public function verifyCallbackData($data, $secretKey)
    {
        if (!isset($data['verify_hash'])) {
            return false;
        }

        $post = $data;
        $verifyHash = $post['verify_hash'];
        unset($post['verify_hash']);
        ksort($post);
        if (isset($post['expire_utc'])){
            $post['expire_utc'] = (string)$post['expire_utc'];
        }
        if (isset($post['tx_urls'])){
            $post['tx_urls'] = html_entity_decode($post['tx_urls']);
        }
        $postString = serialize($post);
        $checkKey = hash_hmac('sha1', $postString, $secretKey);

        if ($checkKey != $verifyHash) {
            return false;
        }

        return true;
    }
}

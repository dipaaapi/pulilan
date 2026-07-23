<?php
/**
 * Modern SMS Gateway Integration (Traccar SMS Gateway)
 * 
 * This class replaces the outdated smsgateway.me service.
 * It is designed to work with the Traccar SMS Gateway Android app.
 */

class SmsGateway {

    private $gatewayUrl;
    private $authorizationToken;

    /**
     * @param string $gatewayUrl The IP address and port of your Android phone running Traccar (e.g., "http://192.168.1.100:8082")
     * @param string $authorizationToken (Optional) The token/password you set in the Traccar app settings
     */
    public function __construct($gatewayUrl, $authorizationToken = '') {
        $this->gatewayUrl = rtrim($gatewayUrl, '/');
        $this->authorizationToken = $authorizationToken;
    }

    /**
     * Sends an SMS message to a specific number.
     * Note: $device and $options parameters are kept for backwards compatibility with older smsgateway.me code, 
     * but are ignored by this new implementation.
     * 
     * @param string $to The recipient's mobile number (e.g., "+639123456789")
     * @param string $message The text message to send
     * @param mixed $device Ignored (for backwards compatibility)
     * @param array $options Ignored (for backwards compatibility)
     * @return array Returns an array with 'success' boolean and 'response' data.
     */
    public function sendMessageToNumber($to, $message, $device = null, $options = []) {
        $data = [
            'to' => $to,
            'message' => $message
        ];

        return $this->makeRequest('/', 'POST', $data);
    }

    /**
     * Internal method to execute the cURL request to the Android phone
     */
    private function makeRequest($endpoint, $method, $data = []) {
        $url = $this->gatewayUrl . $endpoint;
        
        $ch = curl_init($url);
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        if (!empty($this->authorizationToken)) {
            // Traccar uses the Authorization header for its token
            $headers[] = 'Authorization: ' . $this->authorizationToken;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Ignore SSL verification in case you are using a local network IP without a certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                'success' => false,
                'error' => $error
            ];
        }

        return [
            'success' => ($httpCode >= 200 && $httpCode < 300),
            'http_code' => $httpCode,
            'response' => json_decode($response, true) ?? $response
        ];
    }
    
    // ==============================================================================
    // DUMMY METHODS FOR BACKWARDS COMPATIBILITY
    // These methods existed in smsgateway.me but are not applicable to Traccar.
    // They are kept here so your old code doesn't crash with "undefined method" errors.
    // ==============================================================================
    
    public function createContact($name, $number) { return ['success' => true]; }
    public function getContacts($page = 1) { return ['success' => true]; }
    public function getContact($id) { return ['success' => true]; }
    public function getDevices($page = 1) { return ['success' => true]; }
    public function getDevice($id) { return ['success' => true]; }
    public function getMessages($page = 1) { return ['success' => true]; }
    public function getMessage($id) { return ['success' => true]; }
}
?>
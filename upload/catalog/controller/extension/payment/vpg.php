<?php

use function PHPUnit\Framework\fileExists;
use function PHPUnit\Framework\throwException;

require_once DIR_SYSTEM . 'library/vpg/vendor/autoload.php';

class ControllerExtensionPaymentVPG extends Controller{    
    public function index()
    {
        $this->load->model('checkout/order');

        $this->load->language('extension/payment/vpg');
        
		if(!isset($this->session->data['order_id'])) {
			return false;
		}
        
        $test_header = false;
        switch ($this->config->get('payment_vpg_environment')) {
            case $this->language->get("environment_virtual"):
                $url = 'https://api.vodapaygatewayuat.vodacom.co.za/V2/Pay/OnceOff';
                $test_header = true;
                break;
            case $this->language->get("environment_uat"):
                $url = 'https://api.vodapaygatewayuat.vodacom.co.za/V2/Pay/OnceOff';
                break;
            case $this->language->get("environment_prod"):
                $url = 'https://api.vodapaygateway.vodacom.co.za/V2/Pay/OnceOff';
                break;
            default:
                $url = null;
                break;
        }
        $file = DIR_STORAGE . "logs/VodapayGateway_Logs.txt";
        $data['button_confirm'] = $this->language->get('button_confirm');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        if ($order_info) {
            $rlength = 10;
            $traceId = substr(
                        str_shuffle(str_repeat(
                            $x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                            ceil($rlength / strlen($x))
                        )),
                        1,
                        32
                    );
            $traceId = str_pad('',12, $traceId, STR_PAD_LEFT);
            $amount = intval(($order_info['total'])* 100);
            $basketItems = $this->getBasketItemsArray($order_info);
            $callback_url = $this->url->link('extension/payment/vpg/callback&', '', true);
            $notification_url = $this->config->get('payment_vpg_notification');
            if (!empty($notification_url)) {
                $notifications = array('CallbackUrl' => $callback_url,
                                    'NotificationUrl' => $notification_url
                                );
            }
            else{
                $notifications = array('CallbackUrl' => $callback_url,
                                    'NotificationUrl' => $callback_url
                                );
            }		    
            $styling = array(
                "logoUrl" => $this->config->get('payment_vpg_merchant_image_url'),
                "bannerUrl" => $this->config->get('payment_vpg_merchant_message_url'),
                "theme"=> 0
            );
            $body = array(
                'delay_settlement' => false,
                'echo_data' => strval($this->session->data['order_id']),
                'trace_id' => strval($traceId),
                'amount' => $amount,
                'basket' => $basketItems,
                'notifications' => $notifications,
                'styling' => $styling
            );

            
            
            $apiInstance = new \VodaPayGatewayClient\Api\PayApi(
                // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
                // This is optional, `GuzzleHttp\Client` will be used as default.
                new \GuzzleHttp\Client()
            );
            $model = new \VodaPayGatewayClient\Model\VodaPayGatewayPayment($body); // \VodaPayGatewayClient\Model\VodaPayGatewayPaymentComplete | VodaPayGatewayPaymentComplete.
            $api_key = $this->config->get('payment_vpg_api'); // string | The API key.
            try {
				$worked = false;
				$result =  new \VodaPayGatewayClient\Model\VodaPayGatewayResponse();
				for ( $i=0; $i<3 ; $i++) 
				{

                    $result = $apiInstance->payOnceOff($model, $api_key, $test_header);
                
                    if( isset($result)) 
                    {
                        $worked = TRUE;
                        break;
                    }
                }
                if($worked == false)
                {
                    $resultError = error_get_last();
                }
                else{
                
                 $responseCode = $result->getResponseCode();
                 if (in_array($responseCode, explode(',',$this->language->get('good_response')))) {
                     //SUCCESS
                     if ($responseCode == "00") {
                            $data['action'] = $result->getinitiationUrl();
                            $data['sessionId'] = $result->getsessionId();
                    }
                 } elseif (in_array($responseCode, explode(',',$this->language->get('bad_response')))) {
                     //FAILURE
                     $responseMessage = $this->language->get($responseCode);
                     $data['error'] = $this->error;
                     
                 }
                 $log_message = "\n--------------------------------------------\n".date("Y-m-d H:i:s")."\n---------------Vodapay Gateway---------------"."\nCustomer ID= ".$model->getEchoData()."\nURL= ".$url."\nTest= ".$test_header."\nRequest Details= ".$model."\nResponse Details= " .$result."\n--------------------------------------------";
                 if (!fileExists($file)) {
                    fopen($file,"w");
                }
        
                file_put_contents($file, $log_message, FILE_APPEND);
        
                }
                if (null === $result->getinitiationUrl()) {
                    throw new Exception("Initiation Url not populated.");
                }
            } catch (Exception $e) {
                
                $this->log->write("\n---------------Vodapay Gateway---------------"."\nCustomer ID= ".$model->getEchoData()."\nURL= ".$url."\nTest= ".$test_header."\nRequest Details= ".$model."\nResponse Details= " .$result."\nError:".$e."\n--------------------------------------------");
            }
        }
        return $this->load->view('extension/payment/vpg', $data);
    }
    
    function getBasketItemsArray($order_info){
        $basketItems = [];
        $line_item_count  = 0;
        foreach ($this->cart->getProducts() as $product) {
            $basketItem = array(
                'lineNumber' => strval(++$line_item_count),
                'Id' => $product['product_id'],
                'barcode' => '054213',
                'quantity' => $product['quantity'],
                'description' => substr($product['name'], 0, 99),
                'amountExVAT' => intval(($product['total'] * 100)),
                'amountVAT' => intval(($product['total'] * 0.15) * 100)
            );
            $basketItems[] = $basketItem;
        }
        return $basketItems;
    }
    
    public function callback()
    {
        $this->load->language('extension/payment/vpg');
        $this->load->model('checkout/order');

        $file = DIR_STORAGE . "logs/VodapayGateway_Logs.txt";
        $results = $_GET;
        $display = "\n------------------------------------------------------\n".date("Y-m-d H:i:s")."\n---------------Vodapay Gateway Response---------------\n";
        if ("yes" == $this->config->get("payment_vpg_debug")) {
            $display .= "GET/POST data: " . isset($results['data'])?$results['data']:$results['?data'];
        }

        $responseObj = json_decode(base64_decode(isset($results['data'])?$results['data']:$results['?data']));
        $responseCode = $responseObj->responseCode;

        $echoData = $responseObj->echoData;
        $meta = json_decode($echoData, TRUE);
        $order = $this->model_checkout_order->getOrder($meta);
        if (in_array($responseCode, explode(',',$this->language->get('good_response')))) {
        //SUCCESS
            if ($responseCode == "00") {

                if (true) {

                    $refId = $responseObj->retrievalReferenceNumber;
                    $txnId = $responseObj->transactionId;
                    $display .= "response REF ID : ". $refId."\n";
                    $display .= "\nresponse TXN ID : ". $txnId;
                    $display .= "\nresponse Order : ". $order;
                    
                    
                    $success_msg = sprintf(
                        "%s payment completed with Transaction Id of '%s'",
                        'Vodapay',
                        $txnId
                    );

                    $this->model_checkout_order->addOrderHistory($order['order_id'],5, $success_msg, true);
                    $this->response->redirect($this->url->link('checkout/success'));;
                }
            }
        } elseif (in_array($responseCode, explode(',',$this->language->get('bad_response')))) {
        //     //FAILURE
        $data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_basket'),
				'href' => $this->url->link('checkout/cart')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_checkout'),
				'href' => $this->url->link('checkout/checkout', '', true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_failed'),
				'href' => $this->url->link('checkout/success')
			);

            $responseMessage = '<p>Response Code '.$responseCode.': '.$this->language->get(strval('r'.$responseCode)).'</p>';
			$data['text_message'] = $this->language->get('text_failed_message').$responseMessage;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('common/success', $data));
        } 

        $display .= "\n------------------------------------------------------\n";

        if (!fileExists($file)) {
            fopen($file,"w");
        }

        file_put_contents($file, $display, FILE_APPEND);

        // error_log($display, 3, $file);
    }
}
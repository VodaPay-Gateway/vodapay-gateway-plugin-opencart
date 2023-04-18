<?php

use function PHPUnit\Framework\fileExists;

require_once DIR_SYSTEM . 'library/vpg/vendor/autoload.php';

class ControllerExtensionPaymentVPG extends Controller
{
    //Gain access to error logging.
    private $error = array();
    //Main function, triggered if no paramaters are passed.
    public function index(): void {
        $this->load->language('extension/payment/vpg');//Import text from language file.
        
        $this->document->setTitle($this->language->get('heading_title'));//Set the title of the document to the value in the language file.

        $this->load->model('setting/setting');
        //Checks if the Admin Extension Configuration form has been submitted, also checks if it is a valid http post.
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_vpg', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
		}
        //ERROR CHECKING
        //Checks if there where any errors overall.
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api'])) {
            $data['error_api'] = $this->error['api'];
        } else {
            $data['error_api'] = '';
        }

        if (isset($this->error['sort_order'])) {
            $data['error_sort_order'] = $this->error['sort_order'];
        } else {
            $data['error_sort_order'] = '';
        }
        //The following are for breadcrumbs.
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/vpg', 'user_token=' . $this->session->data['user_token'], true),
        );

        //Validate variables
        if (isset($this->request->post['payment_vpg_api'])) {
			$data['API'] = $this->request->post['payment_vpg_api'];
		} else {
			$data['API'] = $this->config->get('payment_vpg_api');
		}

        if (isset($this->request->post['payment_vpg_status'])) {
			$data['Status'] = $this->request->post['payment_vpg_status'];
		} else {
			$data['Status'] = $this->config->get('payment_vpg_status');
		}

        if (isset($this->request->post['payment_vpg_sort_order'])) {
			$data['Sort_Order'] = $this->request->post['payment_vpg_sort_order'];
		} else {
			$data['Sort_Order'] = $this->config->get('payment_vpg_sort_order');
		}

        if (isset($this->request->post['payment_vpg_environment'])) {
			$data['Environment'] = $this->request->post['payment_vpg_environment'];
		} else {
			$data['Environment'] = $this->config->get('payment_vpg_environment');
		}

        if (isset($this->request->post['payment_vpg_notification'])) {
			$data['Notification'] = $this->request->post['payment_vpg_notification'];
		} else {
			$data['Notification'] = $this->config->get('payment_vpg_notification');
		}

        if (isset($this->request->post['payment_vpg_merchant_image_url'])) {
			$data['Image_URL'] = $this->request->post['payment_vpg_merchant_image_url'];
		} else {
			$data['Image_URL'] = $this->config->get('payment_vpg_merchant_image_url');
		}

        if (isset($this->request->post['payment_vpg_merchant_message_url'])) {
			$data['Message_URL'] = $this->request->post['payment_vpg_merchant_message_url'];
		} else {
			$data['Message_URL'] = $this->config->get('payment_vpg_merchant_message_url');
		}

        if (isset($this->request->post['payment_vpg_test'])) {
			$data['Testing'] = $this->request->post['payment_vpg_test'];
		} else {
			$data['Testing'] = $this->config->get('payment_vpg_test');
		}

        //Assigning the Form action URL. URL is 
        $data['save'] = $this->url->link('extension/payment/vpg', 'user_token=' . $this->session->data['user_token'], true);
        //Assigning the Form action URL. URL is 
        $data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/vpg', $data));
    }

    public function order_info(&$route, &$data, &$output) {

        $this->load->model('extension/payment/vpg');
        $this->load->model('sale/order');

        $order_id = $this->request->get['order_id'];
        $order_info = $this->model_sale_order->getOrder($order_id);
        $order_history = $this->model_sale_order->getOrderHistories($order_id,0);
        $order_status = $order_history[0]['status'];

        if ($order_info['payment_code'] == 'vpg' && ($order_status  == 'Complete' || $order_status  == 'Refunded')){

           
            $amount_refunded =  array_sum(array_column($this->model_extension_payment_vpg->getOrderRefundTotal($order_id), 'value'));
            $tab['title'] = 'Vodapay Gateway Refund';
            $tab['code'] = 'vpg_refund';

            $params['user_token'] = $data['user_token'];
            $params['order_id'] = $order_id;
            $params['transaction_id'] = $this->getTransactionId($order_history);
            $params['status'] = $order_status;
            $params['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
            $params['amount_refunded'] = $this->currency->format($amount_refunded, $order_info['currency_code'], $order_info['currency_value']);
            $params['is_refunded'] = (empty($params['amount_refunded']))?0:1;
            $params['fully_refunded'] = ($order_info['total'] != $amount_refunded)?0:1;

            $content = $this->load->view('extension/payment/vpg_refund', $params);

            $tab['content'] = $content;
            $data['tabs'][] = $tab;
        
        }
    }

    public function refund() {
        $this->load->language('extension/payment/vpg');
        $this->load->model('extension/payment/vpg');
        
        $response = array();
        $status = 0;
        $log_message = '';
        $file = DIR_STORAGE . "logs/VodapayGatewayRefund_Logs.txt";
        $result =  new \VodaPayGatewayClient\Model\VodaPayGatewayRefundResponse();

        try {
            if (isset($this->request->post['order_id'])) {
                $order_id = $this->request->post['order_id'];
            } else {
                $order_id = 0;
            }

            if (isset($this->request->post['vpg_refund_amount'])) {
                $vpg_refund_amount = (double)filter_var($this->request->post['vpg_refund_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);;
            } else {
                $vpg_refund_amount = 0;
            }

            if (isset($this->request->post['vpg_refund_paid'])) {
                $vpg_refund_paid = (double)filter_var($this->request->post['vpg_refund_paid'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);;
            } else {
                $vpg_refund_paid = 0;
            }

            if (isset($this->request->post['transaction_id'])) {
                $transaction_id = $this->request->post['transaction_id'];
            } else {
                $transaction_id = 0;
            }

            $this->load->model('sale/order');
            $order_info = $this->model_sale_order->getOrder($order_id);

            $order_total_paid = $order_info['total'];

            

            if ($vpg_refund_amount <= 0) {
                throw new \Exception('Refund amount may not be zero and below.');
            }

            if (($vpg_refund_amount + $vpg_refund_paid) > $order_total_paid) {
                throw new \Exception('Refund amount may not be greater than (R '.$order_total_paid.')');
            }

            $test_header = false;
            switch ($this->config->get('payment_vpg_environment')) {
                case $this->language->get("environment_virtual"):
                    $url = 'https://api.vodapaygatewayuat.vodacom.co.za';
                    $test_header = true;
                    break;
                case $this->language->get("environment_uat"):
                    $url = 'https://api.vodapaygatewayuat.vodacom.co.za';
                    break;
                case $this->language->get("environment_prod"):
                    $url = 'https://api.vodapaygateway.vodacom.co.za';
                    break;
                default:
                    $url = null;
                    break;
            }
            $rlength = 10;
            $traceId = substr(
                str_shuffle(str_repeat(
                    $x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    ceil($rlength / strlen($x))
                )),
                1,
                32
            );
            
            $traceId = str_pad($this->session->data['user_token'], 12, $traceId, STR_PAD_LEFT);
            $amount = $vpg_refund_amount * 100;
            $notification_url = $this->config->get('payment_vpg_notification');
            $notifications = array('notification_url' => !empty($notification_url)?$notification_url:'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

            $body = array(
                'echo_data' => strval($order_id),
                'trace_id' => strval($traceId),
                'original_transaction_id' => strval($transaction_id),
                'amount' => $amount,
                'notifications' => $notifications

            );

            $config = new \VodaPayGatewayClient\Configuration();
            $config->setHost($url);
            $apiInstance = new \VodaPayGatewayClient\Api\PayApi(
                // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
                // This is optional, `GuzzleHttp\Client` will be used as default.
                new \GuzzleHttp\Client(),
                $config
            );
            $model = new \VodaPayGatewayClient\Model\VodaPayGatewayRefund($body); // \VodaPayGatewayClient\Model\VodaPayGatewayPaymentComplete | VodaPayGatewayPaymentComplete.
            $api_key = $this->config->get('payment_vpg_api'); // string | The API key.

            try {
				$worked = false;
				
				for ( $i=0; $i<3 ; $i++) 
				{

                    $result = $apiInstance->payRefund($model, $api_key, $test_header);
                
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
                        $success_msg = sprintf("Vodapay refund completed with amount %s",$this->currency->format($vpg_refund_amount, $order_info['currency_code'], $order_info['currency_value']));
                        $this->model_extension_payment_vpg->addOrderHistory($order_id,11, $success_msg, true);
                        $this->model_extension_payment_vpg->addOrderRefundTotal($order_id, $vpg_refund_amount);
                        $message = $success_msg;
                        $status = 1;
                        $log_message = "\n----------------------------------------------------\n".date("Y-m-d H:i:s")."\n---------------Vodapay Gateway Refund---------------"."\Order ID= ".$model->getEchoData()."\nURL= ".$url."\nTest= ".$test_header."\nRequest Details= ".$model."\nResponse Details= " .$result."\n----------------------------------------------------";
                 }
                }
            } catch (Exception $e) {
                
                $message = $e->getMessage();
                $this->log->write("\n-----------Vodapay Gateway Refund-----------"."\nOrder ID= ".$model->getEchoData()."\nTest= ".strval($test_header)."\nRequest Details= ".$model."\nResponse Details= " .$result."\nError:".$e."\n--------------------------------------------");
            }

            if (!isset($message)){
                $message = json_encode($result);
                $status = 1;
            }
            
        } catch (\Exception $e) {
            $message = 'Refund Payment Failed: '.$e->getMessage();
        }

        if (!fileExists($file)) {
            fopen($file,"w");
        }

        file_put_contents($file, $log_message, FILE_APPEND);

        $response['status'] = $status;
        $response['message'] = $message;

        echo json_encode($response);
        exit;
    }

    function getTransactionId($order_history) {
        $comment_vodapay_message = 	"Vodapay payment";
        foreach ($order_history as $key => $val) {
            if (isset($val['comment'])) {
                if (strpos($val['comment'], $comment_vodapay_message) !== false) {
                    preg_match('/\'([^"]+)\'/', $val['comment'], $transaction_id);
                    return $transaction_id[1];
                }
            }  
        }
        return null;
    }

    public function install() {
        $this->load->model('extension/payment/vpg');
        $this->model_extension_payment_vpg->install();
    }

    public function uninstall() {
            $this->load->model('extension/payment/vpg');
            $this->model_extension_payment_vpg->uninstall();
    }

    public function save(): void {
        $this->load->language('extension/payment/vpg');
				
        
		
		$data['error'] = $this->error;
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
    }

    private function validate(): bool {
		if (!$this->user->hasPermission('modify', 'extension/payment/vpg')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payment_vpg_api']) {
			$this->error['api'] = $this->language->get('error_api');
		}

        if (!$this->request->post['payment_vpg_sort_order']) {
			$this->error['sort_order'] = $this->language->get('error_sort_order');
		}

		return !$this->error;
	}
}
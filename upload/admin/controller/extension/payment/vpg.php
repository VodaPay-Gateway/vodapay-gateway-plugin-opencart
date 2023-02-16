<?php
class ControllerExtensionPaymentVPG extends Controller
{
    //Gain access to error logging.
    private $error = array();

    //Main function, triggered if no paramaters are passed.
    public function index(): void
    {
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
    public function install(): void
    {
        shell_exec("cd ". DIR_SYSTEM . "library/vpg/ && composer update");
    }

    public function save(): void
    {
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
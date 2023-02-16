<?php
class ModelExtensionPaymentVPG extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/vpg');

		if (strtoupper($this->session->data['currency']) != 'ZAR') {
			$status = false;
		} else {
			$status = true;
		}

		
		$method_data =  array();

		if ($status) {
			$method_data = array(
				'code'       => 'vpg',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('payment_vpg_sort_order')
			);
		}

		return $method_data;
	}
}
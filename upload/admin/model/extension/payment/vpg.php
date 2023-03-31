<?php

class ModelExtensionPaymentVPG extends Model 
{

	public function install() {
        $this->load->model('setting/event');
        $this->model_setting_event->addEvent('payment_vpg', 'admin/view/sale/order_info/before', 'extension/payment/vpg/order_info');
	}

	public function uninstall() {
        $this->load->model('setting/event');
        $this->model_setting_event->deleteEventByCode('payment_vpg');
	}

    public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $override = false) {
		$this->load->model('sale/order');

		$order_info = $this->model_sale_order->getOrder($order_id);
		
		if ($order_info) {
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
		}
	}

    public function addOrderRefundTotal($order_id, $value){
		$query = $this->getOrderRefundTotal($order_id);

		if (count($query) > 0) {
			$this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET value = '" . (float)(array_column($query, 'value')[0] + $value) . "' WHERE order_id = '" . (int)$order_id . "' AND code = 'refund'");
		}
		else{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "order_total`(order_id,code,title,value,sort_order) VALUES ('" . (int)$order_id . "', 'refund', 'Refund', '" . (float)$value . "', 11)");
		}
    	
    }

    public function getOrderRefundTotal($order_id){
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' AND code = 'refund' ORDER BY sort_order ASC");

        return $query->rows;
    }
}
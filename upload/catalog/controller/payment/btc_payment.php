<?php
class ControllerPaymentBtcPayment extends Controller {
	protected function index() {
        $this->load->model('checkout/order');
        $order_id = $this->session->data['order_id'];		
		$order_info = $this->model_checkout_order->getOrder($order_id);


		if($this->config->get('btc_payment_add_percent') != 0){
			$total_order_usd = $order_info['total'] * (1 + $this->config->get('btc_payment_add_percent')/100);
		}else{
			$total_order_usd = $order_info['total'];
		}

		if(!isset($this->session->data['order_time']) || ($this->session->data['order_time']+900 < time()) || $total_order_usd != $this->session->data['total_usd']){
			$btc_value = file_get_contents('https://blockchain.info/tobtc?currency=USD&value='.$total_order_usd);
			$this->session->data['order_time'] = time();
			$this->session->data['total_btc'] = $btc_value;
			$this->session->data['total_usd'] = $total_order_usd;
			$this->data['order_payment_timelimit'] = $this->session->data['order_time']+900;
		}else{
			$this->data['order_payment_timelimit'] = $this->session->data['order_time']+900;
		}

		//date('Y-m-d h:i:s',time());

		$this->language->load('payment/btc_payment');
		
		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_description'] = sprintf($this->language->get('text_description'),$this->session->data['total_btc']);
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_time_request'] = $this->language->get('text_time_request');
		$this->data['text_timeleft'] = $this->language->get('text_timeleft');
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['wallet'] = nl2br($this->config->get('btc_payment_wallet'));
		$this->data['continue'] = $this->url->link('checkout/success');
		//$this->data['timezone'] = $this->config->get('btc_payment_timezone');
		$this->data['total_btc'] = $this->session->data['total_btc'];
		$this->data['total_order_usd'] = $total_order_usd;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/btc_payment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/btc_payment.tpl';
		} else {
			$this->template = 'default/template/payment/btc_payment.tpl';
		}	
		
		$this->render(); 
	}
	
	public function confirm() {
		$this->language->load('payment/btc_payment');
		
		$this->load->model('checkout/order');
		
		$comment  = $this->language->get('text_title') . "\n\n";
		$comment .= $this->config->get('btc_payment_wallet') . "\n\n";
		$comment .= sprintf($this->language->get('text_paymenttime'), $this->session->data['order_time'], $this->session->data['order_time']);
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('btc_payment_order_status_id'), $comment, true);
	}
}
?>
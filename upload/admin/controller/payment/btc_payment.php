<?php 
class ControllerPaymentBtcPayment extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/btc_payment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('btc_payment', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_wallet'] = $this->language->get('entry_wallet');
		//$this->data['entry_timezone'] = $this->language->get('entry_timezone');
		$this->data['entry_price_change_amount'] = $this->language->get('entry_price_change_amount');
		$this->data['entry_disable_price_change'] = $this->language->get('entry_disable_price_change');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_add_percent'] = $this->language->get('entry_add_percent');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');			
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		if (isset($this->error['error_wallet'])) {
			$this->data['error_wallet'] = $this->error['error_wallet'];
		} else {
			$this->data['error_wallet'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/btc_payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/btc_payment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/language');

		if (isset($this->request->post['btc_payment_wallet'])) {
			$this->data['btc_payment_wallet'] = $this->request->post['btc_payment_wallet'];
		} else {
			$this->data['btc_payment_wallet'] = $this->config->get('btc_payment_wallet'); 
		} 		
		
		$this->data['languages'] = $languages;
		
		if (isset($this->request->post['btc_payment_total'])) {
			$this->data['btc_payment_total'] = $this->request->post['btc_payment_total'];
		} else {
			$this->data['btc_payment_total'] = $this->config->get('btc_payment_total'); 
		} 

		if (isset($this->request->post['btc_payment_add_percent'])) {
			$this->data['btc_payment_add_percent'] = $this->request->post['btc_payment_add_percent'];
		} else {
			$this->data['btc_payment_add_percent'] = $this->config->get('btc_payment_add_percent'); 
		} 
				
		if (isset($this->request->post['btc_payment_order_status_id'])) {
			$this->data['btc_payment_order_status_id'] = $this->request->post['btc_payment_order_status_id'];
		} else {
			$this->data['btc_payment_order_status_id'] = $this->config->get('btc_payment_order_status_id'); 
		}

		/*if (isset($this->request->post['btc_payment_timezone'])) {
			$this->data['btc_payment_timezone'] = $this->request->post['btc_payment_timezone'];
		} else {
			$this->data['btc_payment_timezone'] = $this->config->get('btc_payment_timezone'); 
		} 		*/ 

		if (isset($this->request->post['btc_payment_price_change_amount'])) {
			$this->data['btc_payment_price_change_amount'] = $this->request->post['btc_payment_price_change_amount'];
		} else {
			$this->data['btc_payment_price_change_amount'] = $this->config->get('btc_payment_price_change_amount'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['bank_transfer_status'])) {
			$this->data['btc_payment_status'] = $this->request->post['btc_payment_status'];
		} else {
			$this->data['btc_payment_status'] = $this->config->get('btc_payment_status');
		}
		
		if (isset($this->request->post['bank_transfer_sort_order'])) {
			$this->data['btc_payment_sort_order'] = $this->request->post['btc_payment_sort_order'];
		} else {
			$this->data['btc_payment_sort_order'] = $this->config->get('btc_payment_sort_order');
		}
		

		$this->template = 'payment/btc_payment.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/btc_payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		if (!$this->request->post['btc_payment_wallet']) {
			$this->error['error_wallet'] = $this->language->get('error_wallet');
		}
		if (preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/i', $this->request->post['btc_payment_wallet']) != 1) {
			$this->error['error_wallet'] = $this->language->get('error_wallet_wrong');
		}			


		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
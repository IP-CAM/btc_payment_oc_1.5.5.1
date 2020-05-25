<?php 
class ModelPaymentBtcPayment extends Model {
  	public function getMethod($address, $total) {
		$this->language->load('payment/btc_payment');
		
		if($this->config->get('btc_payment_status') == true) {
			$status = true;
		}

		if ($this->config->get('btc_payment_total') > 0 && $this->config->get('btc_payment_total') > $total) {
			$status = false;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'btc_payment',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('btc_payment_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>
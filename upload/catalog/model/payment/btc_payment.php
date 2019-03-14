<?php 
class ModelPaymentBtcPayment extends Model {
  	public function getMethod($address, $total) {
		$this->language->load('payment/btc_payment');
		

		$json = file_get_contents('https://api.coinmarketcap.com/v1/ticker/bitcoin/');
		$obj = json_decode($json);
		$btc_percent_change_24h = abs($obj[0]->percent_change_24h);
		$percent_change_7d = abs($obj[0]->percent_change_7d);

		if($this->config->get('btc_payment_status') == true) {
			$status = true;
		}

		if($this->config->get('btc_payment_price_change_amount') != null && $this->config->get('btc_payment_price_change_amount') != 0){
			if($btc_percent_change_24h > $this->config->get('btc_payment_price_change_amount') || $percent_change_7d > $this->config->get('btc_payment_price_change_amount')){
				$status = false;
			}
		}elseif ($this->config->get('btc_payment_total') > 0 && $this->config->get('btc_payment_total') > $total) {
			$status = false;
		}else {
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
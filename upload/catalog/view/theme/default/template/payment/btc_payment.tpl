<?php $sec_left = $order_payment_timelimit - time(); ?>



<h2 class="btc_payment_title"><?php echo $text_instruction; ?></h2>
<div class="content" style="text-align:center">
  <p class="btc_payment_top_description"><?php echo $text_description; ?></p>
  <p class="btc_payment_wallet_address"><?php echo $wallet; ?></p>
  <p class="btc_payment_qr_code"><img src="https://chart.googleapis.com/chart?cht=qr&chl=bitcoin:<?php echo $wallet; ?>?amount=<?php echo $total_btc; ?>&chs=200x200&chld=M|0"></p>
  <p class="btc_payment_order_time"><?php echo $text_time_request .' <span id="btc_payment_countdown"></span>' ?> </p>
  <p class="btc_payment_bottom_description"><?php echo $text_payment; ?></p>
  <p><?php // echo $order_payment_timelimit.' - '.time(). ' = ' .$sec_left; ?> </p>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/btc_payment/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//--></script> 
<script>
    function countdown(seconds) {
		var counter = document.getElementById("btc_payment_countdown");
		counter.innerHTML = Math.floor(seconds / 60) + ':' + ('0' + seconds % 60).slice(-2);
		var timerinterval = setInterval(function(){
			if( seconds > 0 ) {
					seconds--;
					counter.innerHTML = Math.floor(seconds / 60) + ':' + ('0' + seconds % 60).slice(-2);
			}else{counter.innerHTML = '<?php echo $text_timeleft ?>';clearInterval(timerinterval);}
		}, 1000);
    }
    countdown(<?php echo $sec_left ?>);
</script>
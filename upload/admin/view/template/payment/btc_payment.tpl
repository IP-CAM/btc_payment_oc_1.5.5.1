<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment/btc_payment.png" alt="bitcoin logo" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_wallet; ?></td>
            <td><input type="text" name="btc_payment_wallet" value="<?php echo $btc_payment_wallet; ?>" size="50" /></td>
              <?php if (isset(${'error_wallet'})) { ?>
              <span class="error"><?php echo ${'error_wallet'}; ?></span>
              <?php } ?></td>
          </tr>          
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="btc_payment_total" value="<?php echo $btc_payment_total; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_add_percent; ?></td>
            <td><input type="number" max="100" min="0" style="width:50px" name="btc_payment_add_percent" value="<?php echo $btc_payment_add_percent; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_price_exchange_api; ?></td>
            <td><select name="btc_payment_price_exchange_api">
                <?php foreach ($exchanges as $exchange) { ?>
                <?php if ($exchange['codename'] == $btc_payment_price_exchange_api) { ?>
                <option value="<?php echo $exchange['codename']; ?>" selected="selected"><?php echo $exchange['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $exchange['codename']; ?>"><?php echo $exchange['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="btc_payment_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $btc_payment_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="btc_payment_status">
                <?php if ($btc_payment_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="btc_payment_sort_order" value="<?php echo $btc_payment_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
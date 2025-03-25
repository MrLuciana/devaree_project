<?php

use chillerlan\QRCode\QRCode;

require_once('../includes/conn.php');
$amount = isset($_GET['amount']) ? $_GET['amount'] : '0';
?>
<div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="paymentModalLabel">ชำระเงินผ่าน QRCode พร้อมเพย์</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        $pp = new \KS\PromptPay();
        $target = '0656208219';
        echo '<img src="' . (new QRCode)->render($pp->generatePayload($target, $amount)) . '" alt="QR Code" />';
        ?>
        <p class="text-center">กรุณาชำระเงินจำนวน <strong><?php echo htmlspecialchars($amount); ?> บาท</strong> ผ่าน QR Code ด้านบน</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">เสร็จสิ้น</button>
      </div>
    </div>
  </div>
</div>
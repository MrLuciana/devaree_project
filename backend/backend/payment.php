<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">การชำระเงิน</h3>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">รายการทั้งหมด</h4>
            <button data-toggle="modal" data-target="#IModal"
              onclick="paymentModalForm('เพิ่มการจอง')" type="button"
              class="btn btn-primary btn-round ms-auto">
              <i class="fa fa-plus"></i>
              เพิ่มรายการ
            </button>
          </div>
          <div class="row mt-3">
            <div class='col d-flex align-items-center'>
              show &nbsp;
              <select id="perPage" class="form-control">
                <?php
                $resultPerPage = array(2, 5, 10, 20, 50, 100);
                $defaultValue = 10; // กำหนดค่าที่ต้องการให้เลือกเริ่มต้น
                foreach ($resultPerPage as $value) {
                ?>
                  <option value="<?= $value; ?>" <?= ($value == $defaultValue) ? 'selected' : ''; ?>>
                    <?= $value; ?>
                  </option>
                <?php } ?>
              </select>
              &nbsp; entries
            </div>
            <div class='col d-flex justify-content-end align-items-center'>
              <ul class="nav" style="display: flex; justify-content: flex-end; align-items: center; margin-right: 10px;">
                <li class="nav-item" style="display: flex; align-items: center;">
                  <input type="text" id="keyWord" onkeyup="checkKeyWord();" placeholder="ค้นหา..."
                    class="form-control" style="height: 28px; font-size: 10pt; width: 150px;">
                  <button class="btn btn-primary" id="btnSearch"
                    style="height: 28px; font-size: 10pt; margin-left: 4px; padding: 2px 8px;"
                    onclick="paymentList(page)">ค้นหา</button>
                  <button class="btn btn-warning" id="btnClear" onclick="clearSearch();"
                    style="height: 28px; margin-left: 4px; padding: 2px 8px;" hidden>
                    <i class="fas fa-times-circle" style="color:#fff; font-size: 12pt;"></i>
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body" id="paymentTables"></div>
      </div>
    </div>
  </div>
</div>

<?php
include('payments/payment-action.php');
$conn->close();
?>
<?php
include 'includes/conn.php'; // เชื่อมต่อฐานข้อมูล

if (!$conn) {
  die("<p class='text-danger text-center'>เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . mysqli_connect_error() . "</p>");
}
?>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">บริการ</h3>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">บริการทั้งหมด</h4>
            <button data-toggle="modal" data-target="#IModal"
              onclick="serviceModalForm('เพิ่มบริการ')" type="button"
              class="btn btn-primary btn-round ms-auto">
              <i class="fa fa-plus"></i>
              เพิ่มรายการ
            </button>
          </div>
        </div>
        <div class="card-body" id="Bdatatables"></div>
      </div>
    </div>
  </div>
</div>

<?php
include('services/service-action.php');
$conn->close();
?>
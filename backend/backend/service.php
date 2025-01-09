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
            <button
              onclick="serviceModalForm('เพิ่มบริการ')"
              class="btn btn-primary btn-round ms-auto">
              <i class="fa fa-plus"></i>
              เพิ่มบริการ
            </button>
          </div>
        </div>
        <div class="card-body" id="Bdatatables"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addRowModal" tabindex="-1" aria-labelledby="ModalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTitle">เพิ่มบริการ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- เนื้อหาจาก service-form.php จะโหลดมาใส่ตรงนี้ -->
      </div>
    </div>
  </div>
</div>

<?php
include('services/service-action.php');
$conn->close();
?>
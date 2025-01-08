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
        <div class="card-body">
          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อบริการ</th>
                  <th>รายละเอียด</th>
                  <th>ราคา (บาท)</th>
                  <th>หมวดหมู่</th>
                  <th>สถานะ</th>
                  <th>จัดการ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM services, service_category WHERE services.scat_id = service_category.scat_id ORDER BY service_id DESC";
                $result = $conn->query($sql);

                if ($result === false) {
                  echo "<tr><td colspan='7' class='text-center text-danger'>เกิดข้อผิดพลาดในการดึงข้อมูล</td></tr>";
                } elseif ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($i = $i + 1); ?></td>
                      <td><?php echo htmlspecialchars($row["service_name"]); ?></td>
                      <td><?php echo htmlspecialchars($row["service_description"]); ?></td>
                      <td><?php echo number_format($row["service_price"]); ?></td>
                      <td><?php echo htmlspecialchars($row["scat_name"]); ?></td>
                      <td>
                        <?php $status = $row['service_status']; ?>
                        <button id="statusButton<?php echo $row['service_id']; ?>" 
                        class="btn btn-<?php echo $status ? 'success' : 'danger'; ?> btn-sm" 
                        onclick="toggleStatus(<?php echo $row['service_id']; ?>, <?php echo $status ? 'false' : 'true'; ?>)">
                          <?php echo $status ? 'เปิด' : 'ปิด'; ?>
                        </button>
                      </td>
                      <td>
                        <a href="service-edit.php?service_id=<?php echo $row["service_id"]; ?>" class="btn btn-primary btn-sm">แก้ไข</a>
                        <!-- <a href="./services/service-delete.php?service_id=<?php echo $row["service_id"]; ?>" class="btn btn-danger btn-sm">ลบ</a> -->
                        <button class="btn btn-danger btn-sm" onclick="serviceModalDelete('<?php echo $row['service_id']; ?>');">ลบ</button>
                      </td>
                    </tr>
                <?php }
                } else {
                  echo "<tr><td colspan='7' class='text-center text-muted'>ไม่มีข้อมูลบริการ</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
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
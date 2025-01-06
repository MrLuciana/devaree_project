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
              class="btn btn-primary btn-round ms-auto"
              data-bs-toggle="modal"
              data-bs-target="#addRowModal">
              <i class="fa fa-plus"></i>
              เพิ่มบริการ
            </button>
            <div
              class="modal fade"
              id="addRowModal"
              tabindex="-1"
              role="dialog"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">
                      <span class="fw-mediumbold"> New</span>
                      <span class="fw-light"> Row </span>
                    </h5>
                    <button
                      type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p class="small">
                      Create a new row using this form, make sure you
                      fill them all
                    </p>
                    <form>
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group form-group-default">
                            <label>Name</label>
                            <input
                              id="addName"
                              type="text"
                              class="form-control"
                              placeholder="fill name" />
                          </div>
                        </div>
                        <div class="col-md-6 pe-0">
                          <div class="form-group form-group-default">
                            <label>Position</label>
                            <input
                              id="addPosition"
                              type="text"
                              class="form-control"
                              placeholder="fill position" />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group form-group-default">
                            <label>Office</label>
                            <input
                              id="addOffice"
                              type="text"
                              class="form-control"
                              placeholder="fill office" />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer border-0">
                    <button
                      type="button"
                      id="addRowButton"
                      class="btn btn-primary">
                      Add
                    </button>
                    <button
                      type="button"
                      class="btn btn-danger"
                      data-dismiss="modal">
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
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
                $sql = "SELECT * FROM services";
                $result = $conn->query($sql);

                if ($result === false) {
                  echo "<tr><td colspan='7' class='text-center text-danger'>เกิดข้อผิดพลาดในการดึงข้อมูล</td></tr>";
                } elseif ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row["service_id"]); ?></td>
                      <td><?php echo htmlspecialchars($row["service_name"]); ?></td>
                      <td><?php echo htmlspecialchars($row["service_description"]); ?></td>
                      <td><?php echo number_format($row["service_price"], 2); ?></td>
                      <td><?php echo htmlspecialchars($row["service_category"]); ?></td>
                      <td><?php echo mb_convert_case(htmlspecialchars($row["service_status"]), MB_CASE_TITLE, "UTF-8"); ?></td>
                      <td>
                        <a href="service-edit.php?service_id=<?php echo $row["service_id"]; ?>" class="btn btn-primary btn-sm">แก้ไข</a>
                        <a href="service-delete.php?service_id=<?php echo $row["service_id"]; ?>" class="btn btn-danger btn-sm">ลบ</a>
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

<?php
$conn->close();
?>
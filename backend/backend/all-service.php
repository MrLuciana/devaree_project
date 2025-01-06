<?php
include 'includes/conn.php'; // เชื่อมต่อฐานข้อมูล
?>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">รายการบริการ</h3>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">รายการบริการทั้งหมด</h4>
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
                  <th>วันที่สร้าง</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // ดึงข้อมูลจากตาราง services
                $sql = "SELECT id, name, description, price, category, status, created_at FROM services";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["description"] . "</td>
                            <td>" . number_format($row["price"], 2) . "</td>
                            <td>" . $row["category"] . "</td>
                            <td>" . ucfirst($row["status"]) . "</td>
                            <td>" . $row["created_at"] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>ไม่มีข้อมูลบริการ</td></tr>";
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
$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
?>

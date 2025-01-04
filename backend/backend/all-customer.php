<?php
include 'includes/conn.php'; // เชื่อมต่อฐานข้อมูล
?>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">รายชื่อลูกค้า</h3>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">รายชื่อลูกค้า</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ</th>
                  <th>นามสกุล</th>
                  <th>Email</th>
                  <th>เบอร์โทร</th>
                  <th>ที่อยู่</th>
                  <th>เมือง</th>
                  <th>ประเทศ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT id, first_name, last_name, email, phone, address, city, country FROM customers";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["first_name"] . "</td>
                            <td>" . $row["last_name"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["phone"] . "</td>
                            <td>" . $row["address"] . "</td>
                            <td>" . $row["city"] . "</td>
                            <td>" . $row["country"] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>ไม่มีข้อมูลลูกค้า</td></tr>";
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

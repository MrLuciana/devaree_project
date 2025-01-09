<?php
include '../includes/conn.php';
$sql = "SELECT * FROM services, service_category WHERE services.scat_id = service_category.scat_id ORDER BY service_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) { ?>
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
                $i = 0;
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
                </tr><?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo "<tr><td colspan='7' class='text-center text-muted'>ไม่มีข้อมูลบริการ</td></tr>";
}
?>
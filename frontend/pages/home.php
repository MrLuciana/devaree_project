<body>
    <?php
    include_once("includes/carousel.php");
    ?>
    <section class="container mt-3">
        <h1>บริการทั้งหมด</h1>
        <section class="row">

            <?php
            require_once 'includes/conn.php';
            include 'includes/head.php';
            $sql = "SELECT * FROM services WHERE ser_active = 'yes'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    // echo "id: " . $row["ser_id"] . " - Name: " . $row["ser_name"] . " " . $row["ser_code"] . "<br>";
            ?>
                    <div class="col-3 g-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo $row['ser_name']; ?></h5>
                                <p class="card-text"><?php echo $row['ser_description']; ?></p>
                                <p class="startingprice m-0">ราคาเริ่มต้น
                                <h4 class="d-inline"><?php echo $row['ser_price1']; ?> บาท</h4>
                                </p>
                                <a class="btn btn-primary"><i class="bi bi-calendar-plus-fill me-2"></i>จองบริการ</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "0 results";
            }
            ?>
        </section>
    </section>
</body>
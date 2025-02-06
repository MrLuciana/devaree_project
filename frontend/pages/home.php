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
            $sql = "SELECT * FROM services, categories WHERE ser_active = 'yes' AND services.cat_id = services.cat_id;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-12 col-md-6 col-lg-4 g-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo $row['ser_name']; ?></h5>
                                <p class="card-text m-0"><?php echo $row['ser_description']; ?></p>
                                <span class="badge text-bg-secondary rounded-pill my-2 "><?php echo $row['cat_name'] ?></span>
                                <p class="startingprice m-0">ราคาเริ่มต้น
                                <h4 class="d-inline fw-bold"><?php echo $row['ser_price1']; ?> บาท</h4>
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
<head>
    <title>หน้าหลัก : NK Wellness & Care</title>
    <style>
        #pricing span:first-child {
            font-size: 10pt;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <?php
    include_once("includes/carousel.php");
    ?>
    <section class="container mt-5">
        <h1 class="text-center">บริการทั้งหมด</h1>
        <section class="row" data-masonry='{"percentPosition": true, "transitionDuration": "0"}'>

            <?php
            require_once 'includes/conn.php';
            $sql = "SELECT services.ser_name, services.ser_description, services.ser_price1, services.ser_price2, services.ser_price3, categories.cat_name FROM services, categories WHERE services.ser_active = 'yes' AND services.cat_id = categories.cat_id ORDER BY services.ser_id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-12 col-md-6 col-lg-4 g-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo $row['ser_name']; ?></h5>
                                <p class="card-text m-0"><?php echo $row['ser_description']; ?></p>
                                <span class="badge text-bg-secondary rounded-pill my-3"><?php echo $row['cat_name'] ?></span>
                                <section class="row" id="pricing">
                                    <div class="col">
                                        <span>1 ชั่วโมง</span>
                                        <h3><?= $row['ser_price1'] ?>฿</h3>
                                    </div>
                                    <div class="col">
                                        <span>2 ชั่วโมง</span>
                                        <h3><?= $row['ser_price2'] ?>฿</h3>
                                    </div>
                                    <div class="col">
                                        <span>3 ชั่วโมง</span>
                                        <h3><?= $row['ser_price3'] ?>฿</h3>
                                    </div>
                                </section>
                                </p>
                                <a class="btn btn-primary" href="index.php?page=reserve"><i class="bi bi-calendar-plus-fill me-2"></i>จองบริการ</a>
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
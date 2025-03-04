<div class="row">

    <!-- แสดงจํานวนผู้ใช้ -->
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">ลูกค้า</p>
                            <h4 class="card-title"><?php echo number_format($total_customers); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- แสดงจํานวนบริการ -->
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">บริการ</p>
                            <h4 class="card-title"><?php echo number_format($total_services); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- แสดงจํานวนคอร์ส -->
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-luggage-cart"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">แพ็กเกจ</p>
                            <h4 class="card-title"><?php echo number_format($total_packages); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div
                            class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="far fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">การจอง</p>
                            <h4 class="card-title"><?php echo number_format($total_bookings); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
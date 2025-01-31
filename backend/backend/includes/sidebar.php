<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo text-white">
                Admin Dashboard
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a href="?page=home">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">รายละเอียด</h4>
                </li>

                <!-- การจอง -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-address-book"></i>
                        <p>การจอง</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="?page=booking">
                                    <span class="sub-item">การจอง</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="sub-item">ปฏิทิน</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <span class="sub-item">ประวัติการใช้งาน</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- บริการ & แพ็กเกจ-->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#product">
                        <i class="fas fa-book-open"></i>
                        <p>บริการ & แพ็กเกจ</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="?page=service">
                                    <span class="sub-item">บริการ</span>
                                </a>
                            </li>
                            <li>
                                <a href="?page=package">
                                    <span class="sub-item">แพ็กเกจ</span>
                                </a>
                            </li>
                            <li>
                                <a href="?page=categories">
                                    <span class="sub-item">หมวดหมู่</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ลูกค้า -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#customer">
                        <i class="fas fa-user"></i>
                        <p>ลูกค้า</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="customer">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="?page=customer">
                                    <span class="sub-item">รายชื่อทั้งหมด</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/buttons.html">
                                    <span class="sub-item">รายละเอียด</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- พนักงาน -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#employee">
                        <i class="fas fa-id-card"></i>
                        <p>พนักงาน</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="employee">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="?page=employee">
                                    <span class="sub-item">รายชื่อทั้งหมด</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/buttons.html">
                                    <span class="sub-item">รายละเอียด</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- การเงิน -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#money">
                        <i class="fas fa-wallet"></i>
                        <p>การเงิน</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="money">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="components/avatars.html">
                                    <span class="sub-item">รายการการเงิน</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/buttons.html">
                                    <span class="sub-item">สลิป</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/gridsystem.html">
                                    <span class="sub-item">Grid System</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
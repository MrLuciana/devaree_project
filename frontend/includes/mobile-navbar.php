<!-- Bottom Navigation -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-bottom d-block d-lg-none py-0">
    <div class="container-fluid px-0">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center py-2 <?= ($page === 'home') ? 'active' : '' ?>" href="index.php">
                    <i class="bi bi-house-door mb-1"></i>
                    <span class="small">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center py-2 <?= ($page === 'reserve') ? 'active' : '' ?>" href="pages/reserve.php">
                    <i class="bi bi-calendar-check mb-1"></i>
                    <span class="small">Reserve</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center py-2 <?= ($page === 'services') ? 'active' : '' ?>" href="#">
                    <i class="bi bi-grid mb-1"></i>
                    <span class="small">Services</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center py-2 <?= ($page === 'account') ? 'active' : '' ?>" href="#">
                    <i class="bi bi-person mb-1"></i>
                    <span class="small">Account</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
.navbar .nav-link {
    color: rgba(255, 255, 255, 0.85);
    transition: color 0.2s;
}

.navbar .nav-link:hover,
.navbar .nav-link.active {
    color: #ffffff;
}

.navbar .bi {
    font-size: 1.25rem;
}

.navbar .small {
    font-size: 0.75rem;
}
</style> -->
<nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-bottom py-0 text-white">
    <div class="container-fluid container-lg px-0 w-100">
        <ul class="nav nav-pills nav-pills-icons  justify-content-center gap-5 w-100">
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center <?= ($page === 'home') ? 'active' : '' ?>" aria-current="page" href="?page=home"><i class="bi bi-house-fill"></i>หน้าหลัก</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center <?= ($page === 'reserve') ? 'active' : '' ?>" href="?page=reserve"><i class="bi bi-calendar-plus-fill"></i>จองบริการ</a>
            </li>
            <li class="nav-item w-auto">
                <a class="nav-link d-flex flex-column align-items-center <?= ($page === 'user') ? 'active' : '' ?>" href="?page=user"><i class="bi bi-person-fill"></i>ผู้ใช้</a>
            </li>
        </ul>
    </div>
</nav>
<style>
    a.nav-link i.bi {
        font-size: 1.5rem;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-white fixed-bottom pt-1 text-white">
    <div class="container-fluid container-lg px-0">
        <ul class="nav nav-pills nav-pills-icons justify-content-center gap-5 w-100">
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
        font-size: 1.8rem;
    }
</style>
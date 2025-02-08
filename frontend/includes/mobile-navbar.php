<nav class="nav">
    <div class="nav__menu" id="nav-menu">
        <ul class="nav__list">
            <li class="nav__item">
                <a href="?page=home" class="nav__link  <?= ($page === 'home' || !isset($page)) ? 'active-link' : '' ?>">
                    <i class="bi bi-house-fill nav__icon"></i>
                    <span class="nav__name">หน้าหลัก</span>
                </a>
            </li>

            <li class="nav__item">
                <a href="?page=reserve" class="nav__link  <?= ($page === 'reserve') ? 'active-link' : '' ?>">
                    <i class="bi bi-calendar-plus-fill nav__icon"></i>
                    <span class="nav__name">จองบริการ</span>
                </a>
            </li>
            <li class="nav-item w-auto">
                <a class="nav-link d-flex flex-column align-items-center <?= ($page === 'user') ? 'active' : '' ?>" href="?page=user"><i class="bi bi-person-fill"></i>ผู้ใช้</a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .nav {
        min-height: 3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
    }

    .nav__menu {
        position: fixed;
        bottom: 0;
        left: 0;
        background-color: #fff;
        box-shadow: 0 -1px 12px hsla(174, 63%, 15%, 0.15);
        width: 100%;
        min-height: 4rem;
        display: grid;
        gap: 5;
        align-content: center;
        border-radius: 1.25rem 1.25rem 0 0;
        transition: .4s;
    }

    .nav__list {
        justify-content: space-around;
    }

    .nav__name {
        font-weight: 400;
        font-size: .85rem;
        overflow: hidden;
        max-width: 100px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .nav__list,
    .nav__link {
        display: flex;
    }

    ul {
        list-style: none;
        margin: 0;
    }

    ul,
    li {
        padding: unset;
    }

    .nav__link {
        flex-direction: column;
        align-items: center;
        row-gap: 4px;
        color: black;
        font-weight: 600;
    }

    a {
        text-decoration: none;
    }

    .active-link {
        position: relative;
        color: red;
        transition: .3s;
    }

    .nav__icon {
        font-size: 1.5rem;
    }

    .nav__item {
        width: 100%;
        text-align: center;
    }
</style>
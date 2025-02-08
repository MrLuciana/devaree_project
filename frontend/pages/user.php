<body>
  <section class="container">
    <h1>หน้าข้อมูลผู้ใช้</h1>
    <p>แสดงรายละเอียดบัญชีผู้ใช้ / ประวัติการใช้บริการ</p>
    <section class="card">
      <div class="card-header">
        <h4 class="m-0"> <?php echo htmlspecialchars($_SESSION['profile']->name); ?></h4>
      </div>
      <div class="card-body">
        <p>ID: <?php echo htmlspecialchars($_SESSION['profile']->userId); ?></p>
        <img src="<?php echo htmlspecialchars($_SESSION['profile']->picture); ?>" alt="Profile Picture" width="200px" class="rounded">
      </div>
    </section>
  </section>
</body>
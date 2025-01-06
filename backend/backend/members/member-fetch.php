<?php
if (isset($_POST['per_page'])) {
    $perPage = $_POST['per_page'] ;
} else {
    $perPage = 5;
}
if (isset($_POST['page_no'])) {
    $page = $_POST['page_no'];
} else {
    $page = 1;
}
$start = ($page - 1) * $perPage;
// echo $page;
$keyword = $_POST['keyword'];

// +======================>
require_once("../includes/conn.php");
if (!empty($keyword)) {
    $sql = "SELECT member.*,program.* FROM member,program WHERE member.pro_id = program.pro_id AND (member.mem_fname LIKE '%$keyword%' || member.mem_lname LIKE '%$keyword%') ORDER BY member.mem_id DESC";
} else {
    $sql = "SELECT member.*,program.* FROM member,program WHERE member.pro_id = program.pro_id ORDER BY member.mem_id DESC LIMIT {$start} , {$perPage}";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    ?>
    <div class="table-responsive-lg">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" style="width: 5%;">ลำดับ</th>
                    <th scope="col" style="width: 10%;">code</th>
                    <th scope="col" style="width: 30%;">ชื่อ-สกุล</th>
                    <th scope="col" style="width: 25%;">หลักสูตร</th>
                    <th scope="col" style="width: 20%;">อีเมล์</th>
                    <th scope="col" style="width: 10%;" class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $start + 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $no; ?></th>
                        <td><?php echo $row['mem_code']; ?></td>
                        <td><?php echo $row['mem_title'] . "" . $row['mem_fname'] . " " . $row['mem_lname']; ?></td>
                        <td><?php echo $row['pro_name']; ?></td>
                        <td><?php echo $row['mem_email']; ?></td>
                        <td>
                            <div class="btn-group">
                                <button data-toggle="modal" data-target="#IModal"
                                    onclick="memberModalDetail(<?php echo $row['mem_id']; ?> , 'แสดงรายละเอียด')"
                                    class="btn btn-primary">
                                    <i class="fas fa-eye"></i></button>
                                <button data-toggle="modal" data-target="#IModal"
                                    onclick="memberModalEdit(<?php echo $row['mem_id']; ?> , 'แก้ไขข้อมูล')"
                                    class="btn btn-success"><i class="fas fa-edit"></i></button>
                                <button onclick="memberModalDelete(<?php echo $row['mem_id']; ?>)" class=" btn btn-danger"><i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $no++;
                } ?>

            </tbody>
        </table>
        <hr style="margin-top:-16px;">
        <?php
        $sql = "SELECT member.*,program.* FROM member,program WHERE member.pro_id = program.pro_id ORDER BY member.mem_id DESC";
        $fetch_query = $conn->query($sql);
        $total_record = mysqli_num_rows($fetch_query);
        $total_page = ceil($total_record / $perPage);
        ?>
        <div class="row">
            <div class="col">
                <nav class="text-center">
                    <ul class="pagination ">
                        <li class="page-item disabled">
                            <div style="margin:10px 10px 10px 0px; width:100pt;">
                                <?php
                                echo "pages " . $page . " of " . $total_page;
                                ?>
                            </div>
                        </li>
                        <?php
                        $range_page = 2;
                        $last_show_page = $page + $range_page;
                        if ($last_show_page > $total_page) {

                            $count_last = $last_show_page - $total_page;
                            $first_show_page = $page - ($range_page + $count_last);
                            $last_show_page = $total_page;
                        } else if ($last_show_page <= $total_page) {
                            $first_show_page = $page - $range_page;
                        }
                        // echo $last_show_page , $count_last;
                        if ($first_show_page < 1) {

                            $first_show_page = 1;
                            $count_first = $page - $first_show_page;
                            $last_show_page = $page + (($range_page * 2) - $count_first);
                            if ($last_show_page > $total_page) {
                                $last_show_page = $total_page;
                            }
                        }

                        ($page == 1) ? $set_disable_back = "disabled" : $set_disable_back = "";
                        ($page == $total_page) ? $set_disable_next = "disabled" : $set_disable_next = "";
                        ?>
                        <li class="page-item <?php echo $set_disable_back; ?>">
                            <a class="page-link" id="1" aria-label="Previous">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?php echo $set_disable_back; ?>">
                            <a class="page-link" id="<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = $first_show_page; $i <= $last_show_page; $i++) {

                            ($i == $page) ? $active = "active" : $active = "";

                            ?>
                            <li class="page-item <?php echo $active; ?>" style="width: 36pt;"><a class="page-link"
                                    id="<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <li class="page-item <?php echo $set_disable_next; ?>">
                            <a class="page-link" id="<?php
                            if ($page < $total_page) {
                                echo $page + 1;
                            } else {
                                echo $page = $total_page;
                            } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?php echo $set_disable_next; ?>">
                            <a class="page-link" id="<?php echo $total_page; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <?php

} else {
    echo "ไม่พบรายการ";
}
// $conn->close();
?>
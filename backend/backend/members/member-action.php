<script>
var valToast;
var page;
$(document).ready(function() {
    memberList(page);
})

// กําหนดหน้า
$(document).on("click", ".pagination a", function() {
    page = $(this).attr('id')
    memberList(page);
    // console.log(page);
});

// เปลี่ยนข้อมูลแต่ละหน้า
$("#perPage").change(function() {
    memberList();
})

// enter to search
$("#keyWord").keyup(function(event) {
    if (event.keyCode === 13) {
        memberList(page);
    }
});

// empty checked
function checkKeyWord() {
    var keyword = document.getElementById('keyWord').value;
    if (keyword) {
        document.getElementById('btnClear').hidden = false;

    } else {
        document.getElementById('btnClear').hidden = true;
    }
}

function clearSearch() {
    document.getElementById('btnClear').hidden = true;
    document.getElementById('keyWord').value = "";
    memberList(page);
}

// แสดงข้อมูล
function memberList(page) {
    var keyword = $('#keyWord').val();
    var perPage = document.getElementById("perPage").value;

    $.ajax({
        type: "POST",
        data: {
            keyword: keyword,
            per_page: perPage,
            page_no: page
        },
        url: "./members/member-fetch.php",
        success: (data, res) => {
            $('#displayMember').html(data);
        }
    })
}



// Modal add member 
function memberModalForm(title) {
    0
    document.getElementById('ModalTitle').innerHTML = title;
    $.ajax({
        url: "./members/member-form.php",
        // type: 'POST',
        success: function(data, status) {
            $('#displayIModalBody').html(data);
        }
    });
}
// Modal display member 
function memberModalDetail(id, title) {
    document.getElementById('ModalTitle').innerHTML = title;
    $.ajax({
        url: "./members/member-detail.php",
        type: 'POST',
        data: {
            id: id
        },
        success: function(data, status) {
            $('#displayIModalBody').html(data);
        }
    });
}
// Modal edit member 
function memberModalEdit(id, title) {
    document.getElementById('ModalTitle').innerHTML = title;
    $.ajax({
        url: "./members/member-edit.php",
        type: 'POST',
        data: {
            id: id
        },
        success: function(data, status) {
            $('#displayIModalBody').html(data);
        }
    });
}
// Add member 
function memberAdd() {
    var title = $('#title').val();
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var pro_id = $('#pro_id').val();
    var email = $('#email').val();
    var password = $('#password').val();
    // console.log(pro_id)
    $.ajax({
        url: "./members/member-add.php",
        type: 'POST',
        data: {
            title: title,
            fname: fname,
            lname: lname,
            pro_id: pro_id,
            email: email,
            password: password
        },
        success: function(data, status) {
            memberList(page);
        }
    });
}
// Update member 
function memberUpdate(id) {

    var title = $('#title').val();
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var pro_id = $('#pro_id').val();
    var email = $('#email').val();
    var password = $('#password').val();
    $.ajax({
        url: "./members/member-update.php",
        type: 'POST',
        data: {
            id: id,
            title: title,
            fname: fname,
            lname: lname,
            pro_id: pro_id,
            email: email,
            password: password
        },
        success: function(data, status) {
            memberList(page);
        }
    });
}
// del member 
function memberModalDelete(id) {
    Swal.fire({
        // title: "Are you sure?",
        text: "ยืนยันการลบรายการนี้",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "./members/member-delete.php",
                type: 'POST',
                data: {
                    id: id
                },
                success: function(data, status) {
                    memberList(page);
                }
            });
        }
    });
}
</script>
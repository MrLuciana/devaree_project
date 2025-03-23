<script>
    var page;
    $(document).ready(function() {
        paymentList(page);
    })

    $("#keyWord").keyup(function(event) {
        if (event.keyCode === 13) {
            paymentList(page);
        }
    });

    // กําหนดหน้า
    $(document).on("click", ".pagination a", function() {
        page = $(this).attr('id')
        paymentList(page);
    });
    // เปลี่ยนข้อมูลแต่ละหน้า
    $("#perPage").change(function() {
        paymentList();
    })

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
        paymentList(page);
    }

    //=========== Modal Function ===========//
    // ฟอร์มดูรายละเอียด
    function paymentModalDetail(id, title) {
        document.getElementById('ModalTitle').innerHTML = title;
        $.ajax({
            url: "./payments/payment-detail.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('#IModal .modal-body').html(data);
                $('#IModal').modal('show');
            }
        });
    }
    //=========== End Modal Function ===========//

    // ฟังก์ชันดึงข้อมูล
    function paymentList(page) {
        var keyword = $('#keyWord').val();
        var perPage = document.getElementById("perPage").value;

        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,
                per_page: perPage,
                page_no: page
            },
            url: "./payments/payment-fetch.php",
            success: (data, res) => {
                $('#paymentTables').html(data);
            }
        })
    }

    // Event Listener สำหรับตรวจจับการเปลี่ยนสถานะ
    $(document).on('change', 'select[name="pay_status"]', function() {
        var pay_id = $(this).data('pay_id');
        var new_status = $(this).val();

        updatePaymentStatus(pay_id, new_status);
    });

    function updatePaymentStatus(pay_id, new_status) {
        $.ajax({
            url: './payments/payment-status.php',
            type: 'POST',
            data: {
                pay_id: pay_id,
                new_status: new_status
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    let message = (new_status === 'paid') ?
                        'ชำระเงินเรียบร้อยแล้ว ✅' :
                        (new_status === 'pending') ?
                        'ยังไม่ได้ชำระเงิน ❌' :
                        'อัพเดตสถานะสำเร็จ';

                    Swal.fire({
                        icon: 'success',
                        title: '✅ สำเร็จ!',
                        text: message,
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '⚠️ ไม่สำเร็จ!',
                        text: response.message || 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.error('❌ AJAX Error:', textStatus, errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: '❌ เกิดข้อผิดพลาด!',
                    html: `<strong>สถานะ:</strong> ${textStatus}<br><strong>รายละเอียด:</strong> ${errorThrown}`,
                    confirmButtonText: 'ปิด'
                });
            }
        });
    }
</script>
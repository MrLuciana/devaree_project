<script>
    var valToast;
    var page;
    
    document.addEventListener("DOMContentLoaded", function() {
        fetch('services/service-fetch.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('displayService').innerHTML = data;
            })
            .catch(error => console.error('Error fetching data:', error));
    });


    $(document).ready(function() {
        serviceList(page);
    })

    // กําหนดหน้า
    $(document).on("click", ".pagination a", function() {
        page = $(this).attr('id')
        serviceList(page);
        // console.log(page);
    });

    // เปลี่ยนข้อมูลแต่ละหน้า
    $("#perPage").change(function() {
        serviceList();
    })

    // แสดงข้อมูล
    function serviceList(page) {
        var keyword = $('#keyWord').val();
        var perPage = document.getElementById("perPage").value;

        $.ajax({
            type: "POST",
            data: {
                keyword: keyword,
                per_page: perPage,
                page_no: page
            },
            url: "./services/service-fetch.php",
            success: (data, res) => {
                $('#displayService').html(data);
            }
        })
    }
</script>
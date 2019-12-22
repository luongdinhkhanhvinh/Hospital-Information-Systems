<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<div class="container">
    <?= $jumbo->getJumbo("Thêm thuốc", "Thêm thuốc") ?>

    <form class='presp' role='form' action='#' onsubmit="addPrep()">
        <input type="hidden" name="type" value="addPresp">
        <div class='form-group'>
            <label for='in_Name' class="fas fa-tablets prefix"> Tên thuốc</label>
            <input name='in_Name' id='in_Name' class='form-control' type='text' placeholder='Tên thuốc' required>
        </div>
        <div class='form-group'>
            <label for='in_Expiry' class="fas fa-calendar"> Hạn sử dùng</label>
            <input name='in_Expiry' id='in_Expiry' class='form-control' type='date' placeholder='Hạn sử dụng' required>
        </div>
        <div class='form-group'>
            <label for='in_Presp' class="fas fa-prescription-bottle-alt prefix"> Đơn thuốc</label>
            <input name='in_Presp' id='in_Presp' class='form-control' type='text' placeholder='Đơn thuốc'>
        </div>
        <div class='form-group'>
            <label for='in_Price' class="fas fa-money-bill prefix"> Giá</label>
            <input name='in_Price' id='in_Price' class='form-control' type='text' placeholder='VND'>
        </div>
        <div class='form-group'>
            <label for='in_Qty' class="fas fa-sort-numeric-up prefix"> Số lượng</label>
            <input name='in_Qty' id='in_Qty' class='form-control' type='number' placeholder='Số lượng'>
        </div>
        <div class='form-group'>
            <input class='btn btn-success' type='submit' value="Thêm đơn thuốc">
        </div>
    </form>
</div>
<?php include "../../includes/footer.php"; ?>

<script>
    function addPrep(e) {
        event.preventDefault();
        var presp = $('.presp').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/presp/PrespController.php',
            data: presp,
            beforeSend: function() {
                Swal.fire({
                    title: "Thêm đơn thuốc",
                    type: "info",
                    timer: 10000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {}, 100)
                    }
                });
            },
            success: function(resp) {
                if (resp == "success") {
                    Swal.fire({
                        title: "Thêm thuốc thành công",
                        type: "success",
                    }).then(result => {
                        window.location.reload();
                    });

                } else {
                    Swal.fire({
                        title: "Lỗi" + resp,
                        type: "error",
                    });
                }
            },

        })
    }
</script>
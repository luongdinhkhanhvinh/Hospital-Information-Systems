<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/presp/PrespController.php";
$drugs = new Presp();
?>
<div class="container">

    <?= $jumbo->getJumbo("Cập nhật thuốc", "Cập nhật danh sách thuốc") ?>

    <?php $drugsList = $drugs->getSinglePresp($_GET['id']);
    $row = $drugsList->fetch(PDO::FETCH_ASSOC); ?>
    <div class="row">
        <div class="col-12 text-center">

            <form class='editPresp' role='form' action='#' onsubmit="updatePresp()">
                <input type="hidden" name="type" value="updatePrespc">
                <input type="hidden" name="id" value='<?= $_GET['id'] ?>'>
                <div class='form-group'>
                    <label for='in_Name' class="fas fa-tablets prefix"> Tên thuốc</label>
                    <input value="<?= $row['name'] ?>" name='in_Name' id='in_Name' class='form-control' type='text' placeholder='Tên thuốc' required>
                </div>
                <div class='form-group'>
                    <label for='in_Expiry' class="fas fa-calendar"> Hạn sử dụng</label>
                    <input value="<?= $row['expiry'] ?>" name='in_Expiry' id='in_Expiry' class='form-control' type='date' placeholder='Hạn sử dụng' required>
                </div>
                <div class='form-group'>
                    <label for='in_Presp' class="fas fa-prescription-bottle-alt prefix"> Đơn thuốc</label>
                    <input value="<?= $row['presp'] ?>" name='in_Presp' id='in_Presp' class='form-control' type='text' placeholder='Đơn thuốc'>
                </div>
                <div class='form-group'>
                    <label for='in_Price' class="fas fa-money-bill prefix"> Giá</label>
                    <input value="<?= $row['price'] ?>" name='in_Price' id='in_Price' class='form-control' type='text' placeholder='VND'>
                </div>
                <div class='form-group'>
                    <label for='in_Qty' class="fas fa-sort-numeric-up prefix"> Số lượng</label>
                    <input value="<?= $row['qty'] ?>" name='in_Qty' id='in_Qty' class='form-control' type='number' placeholder='Số lượng'>
                </div>
                <div class='form-group'>
                    <input class='btn btn-success' type='submit' value="Cập nhật đơn thuốc">
                </div>
            </form>

            <?php include "../../includes/footer.php"; ?>


            <script>
                function updatePresp(e) {
                    event.preventDefault();
                    var form = $('.editPresp').serialize();
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/presp/PrespController.php',
                        data: form,
                        beforeSend: function() {
                            Swal.fire({
                                title: "Đang chờ xử lý",
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
                                    title: "Cập nhật đơn thuốc thành công",
                                    type: "success",
                                }).then(result => {
                                    window.history.back();
                                });
                            } else {
                                Swal.fire({
                                    title: "Lỗi" + resp,
                                    type: "error",
                                }).then(result => {
                                    window.history.back();
                                });
                            }
                        },

                    })
                }
            </script>
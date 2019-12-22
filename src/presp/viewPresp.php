<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/presp/PrespController.php";
$drugs = new Presp();
?>
<div class="container">

    <?= $jumbo->getJumbo("Xem thuốc", "Xem danh sách thuốc") ?>

    <?php $drugsList = $drugs->getAllPresp(); ?>
    <div class="row">
        <div class="col-12 text-center">

            <table class="table table-hover table-responsive-sm table-striped">
                <thead>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Đơn thuốc</th>
                    <th>Hạn sử dụng</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Hoạt động</th>
                </thead>

                <tbody>
                    <?php while ($row = $drugsList->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $row['drug_id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['presp'] ?></td>
                            <td><?= $row['expiry'] ?></td>
                            <td>VND <?= $row['price'] ?></td>
                            <td><?= $row['qty'] ?></td>
                            <td><button title="Xóa thuốc" class="delete btn btn-danger btn-sm fa fa-trash-o" onclick="Delete(<?= $row['drug_id'] ?>)"></button>
                                <a href="updatePresp.php?id=<?= $row['drug_id'] ?>" title="Chỉnh sửa thuốc" class="warning btn btn-warning btn-sm fa fa-pencil"></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php include "../../includes/footer.php"; ?>






    <script>
        function Delete(id) {
            event.preventDefault();
            Swal.fire({
                title: "Bạn có chắc chắn muốn xóa ID thuốc không? " + id + " ?",
                text: "Bạn sẽ không thể khôi phục những gì bạn đã xóa!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                animation: true,
                cancelButtonColor: "#d33",
                confirmButtonText: "Vâng, Tôi xóa chúng!"
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '../../includes/presp/PrespController.php',
                        data: {
                            type: "deleteDrug",
                            id: id
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: "Xóa thuốc",
                                type: "info",
                                text: "Deleting Drug " + id,
                                icon: "info",
                            })
                        },
                        success: function(resp) {
                            if (resp = "success") {
                                Swal.fire({
                                    text: "Xóa thuốc",
                                    type: "success",
                                    showConfirmButton: true,
                                    timer: 10000,
                                    animation: true,
                                }).then(result => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Lỗi",
                                    type: "error",
                                    text: "Hình như có gì đó không đúng " + resp,
                                    icon: "error",
                                    button: "Try Again",
                                    showConfirmButton: true,
                                }).then(result => {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                }
            });

        }
    </script>
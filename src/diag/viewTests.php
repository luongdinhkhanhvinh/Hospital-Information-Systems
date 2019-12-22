<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/tests/TestsController.php";
$tests = new Tests();
?>
<div class="container">
    <?= $jumbo->getJumbo("Kiểm tra về bệnh nhân", "Xem về bệnh nhân") ?>

    <?php $patientsList = $tests->viewTest($_GET['id']); ?>
    <a title="Chuyển bệnh nhân" onclick="modal(<?= $_GET['id'] ?>)" class="btn btn-sm btn-default fa fa-ambulance"></a> </td>

    <table class="table table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>Họ </th>
            <th>Tên</th>
            <th>Kiểm tra tên</th>
            <th>Kết quả</th>
            <th>Hoạt động</th>
        </thead>


        <tbody>
            <?php while ($row = $patientsList->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['test_name'] ?></td>
                    <td><?= $row['result'] ?></td>
                    <td><a title="Thêm đơn thuốc" href="../patients/addDiagnosis.php?t_id=<?= $row['test_id'] ?>&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-default fa fa-plus"></a>
                        <a title="Xem đơn thuốc" href="../patients/viewDiag.php?t_id=<?= $row['test_id'] ?>&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-default fa fa-eye"></a>
                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>



<?php include "../../includes/footer.php"; ?>


<script>
    function Delete(id) {
        event.preventDefault();
        Swal.fire({
            title: "Bạn có chắc chắn muốn xóa ID của bệnh nhân không ? " + id + " ?",
            text: "Bạn sẽ không thể khôi phục chúng khi bạn đã xóa!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            animation: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Vâng, Xóa chúng!"
        }).then(result => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: '../../includes/patients/PatientsController.php',
                    data: {
                        type: "deletePatient",
                        id: id
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: "Xóa bệnh nhân",
                            type: "info",
                            text: "Xóa bệnh nhân " + id,
                            icon: "info",
                        })
                    },
                    success: function(resp) {
                        if (resp = "success") {
                            Swal.fire({
                                text: "Xóa bệnh nhân",
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
                                text: "Có lỗi ở chổ nào đó " + resp,
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

    function refer(e) {
        event.preventDefault();
        var form = $('.refer').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/patients/PatientsController.php',
            data: form,
            beforeSend: function() {
                Swal.fire({
                    title: "Chuyển bệnh nhân",
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
                        title: "Chuyển bệnh nhân thành công",
                        type: "success",
                    }).then(result => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Lỗi" + resp,
                        type: "error",
                    }).then(result => {
                        window.location.reload();
                    });




                }
            },

        })
    }
</script>


<div id="publish" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chuyển bệnh nhân</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="refer" action="" onsubmit="refer()">
                    <input type="hidden" name="type" value="refer">
                    <input class="id" type="hidden" name="id" value="">
                    <input type="text" name="reason" class="form-control" placeholder="Lý do chuyển" required>
                    <br>
                    <input type="text" name="name" class="form-control" placeholder="Chuyển bệnh viện" required>
                    <input type="submit" class="btn btn-success">
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script>
    function modal(id) {
        event.preventDefault();
        $('.modal').modal('show');
        $('.id').attr("value", id);
    }
</script>
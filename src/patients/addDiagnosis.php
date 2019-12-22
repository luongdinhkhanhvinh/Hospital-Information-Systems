<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->getPatient($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <?= $jumbo->getJumbo("Thêm " . $patient['firstname'] . " " . $patient['lastname'] . "bệnh nhân", "<a href='viewDiag.php?id=" . $patient['user_id'] . "'>Xem chuẩn đoán trước</a>") ?>

    <form role='form' class="addDiag" onsubmit="addDiag()">
        <input name='type' type="hidden" value="addDiag">
        <input name='id' type="hidden" value=<?= $patient['user_id'] ?>>
        <?php if (isset($_GET['t_id'])) : ?>
            <input name='test_id' type="hidden" value=<?= $_GET['t_id'] ?>>
        <?php endif ?>
        <div class='form-group'>
            <label for='in_Temp' class="fas fa-temperature-high"> Nhiệt độ</label>
            <input name='in_Temp' id='in_Temp' class='form-control' type='text' placeholder='Nhiệt độ' required>
        </div>
        <div class='form-group'>
            <label for='in_Bp' class="fas fa-digital-tachograph"> Bp</label>
            <input name='in_Bp' id='in_Bp' class='form-control' type='text' placeholder='Bp' required>
        </div>

        <div class='form-group'>
            <label for='in_Presp1' class="fas fa-prescription-bottle-alt"> Đơn thuốc</label>
            <input name='in_Presp1' id='in_Presp1' class='form-control' type='text' placeholder='Đơn thuốc'>
        </div>
        <div class='form-group'>
            <label for='in_Remarks' class="fas fa-pencil-alt"> Nhận xét</label>
            <input name='in_Remarks' id='in_Remarks' class='form-control' type='text' placeholder='Nhận xét' required>
        </div>
        <div class='form-group'>
            <input type="submit" value="Thêm chuẩn đoán bệnh nhân" class="btn btn-success">
        </div>
    </form>
</div>


<?php include "../../includes/footer.php"; ?>

<script>
    function addDiag(e) {
        event.preventDefault();
        var form = $('.addDiag').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/patients/PatientsController.php',
            data: form,
            beforeSend: function() {
                Swal.fire({
                    title: "Thêm đơn thuốc bệnh nhân",
                    type: "info",
                    timer: 10000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {}, 100);
                    }
                });
            },
            success: function(resp) {
                if (resp == "success") {
                    Swal.fire({
                        title: "Đơn thuốc bệnh nhân được lưu hoàn thành",
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
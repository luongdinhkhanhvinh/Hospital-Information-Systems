<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->viewChildHeight($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <?= $jumbo->getJumbo("Chỉnh sửa " . $patient['firstname'] . " " . $patient['lastname'] . "'s Height and Age", "") ?>

    <form method='POST' class='editChild' action='#' onsubmit="editPatient()">
        <input type="hidden" name="type" value="editChild" id="">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>" id="">
        <div class='form-group'>
            <label for='in_Dob'>Giới tính</label>
            <select class="browser-default" name="in_Gender">
                <option value="<?= $patient['gender'] ?>"><?= $patient['gender'] ?>
                </option>
                <option value="male">Nam
                </option>
                <option value="female">Nữ</option>
            </select>
        </div>
        <div class='form-group'>
            <label for='in_Dob'>Ngày sinh</label>
            <input name='in_Dob' value="<?= $patient['dob'] ?>" id='in_Dob' class='form-control' type='date' placeholder='Ngày sinh' required>
        </div>
        <div class='form-group'>
            <label for='in_Height'>Chiều cao (CM)</label>
            <input name='in_Height' value="<?= $patient['height'] ?>" id='in_Height' class='form-control' type='number' placeholder='Chiều cao' required>
        </div>
        <div class='form-group'>
            <label for='in_Weight'>Cân nặng (KG)</label>
            <input name='in_Weight' value="<?= $patient['weight'] ?>" id='in_Weight' class='form-control' type='number' placeholder='Cân nặng' required>
        </div>
        <div class='form-group'>
            <label for='in_HeadC'>Vòng đầu (CM)</label>
            <input name='in_HeadC' value="<?= $patient['headc'] ?>" id='in_HeadC' class='form-control' type='number' placeholder='Vòng đầu' required>
        </div>
        <div class='form-group'>
            <label for='in_Bmi'>BMI</label>
            <input name='in_Bmi' value="<?= $patient['bmi'] ?>" id='in_Bmi' class='form-control' type='number' placeholder='BMI' required>
        </div>
        <div class='form-group'>
            <input type="submit" value="Cập nhật bệnh nhân" class="btn btn-success">
    </form>
    <button type="button" class="btn btn-primary" data-toggle="popover" data-html='true' data-placement="top" title="Loại biểu đồ" data-content="
    <a class='btn btn-sm btn-default' href='wfa.php?id=<?= $_GET['id'] ?>'>Bệnh nhân</a><br>
    <a class='btn btn-sm btn-default' href='hfa.php?id=<?= $_GET['id'] ?>'>Chiều cao theo tuổi</a><br>
    <a class='btn btn-sm btn-default' href='wfh.php?id=<?= $_GET['id'] ?>'>Cân nặng theo chiều cao</a><br>
    <a class='btn btn-sm btn-default' href='bfa.php?id=<?= $_GET['id'] ?>'>BMI theo tuổi</a><br>
    <a class='btn btn-sm btn-default' href='hcfa.php?id=<?= $_GET['id'] ?>'>Vòng đầu theo tuổi</a><br>
    ">Đồ thị</button>
</div>

</div>


<?php include "../../includes/footer.php"; ?>


<script>
    function editPatient(e) {
        event.preventDefault();
        var form = $('.editChild').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/patients/PatientsController.php',
            data: form,
            beforeSend: function() {
                Swal.fire({
                    title: "Đang chờ phản hồi",
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
                        title: "Cập nhật thành công",
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

    $(function() {
        $('[data-toggle="popover"]').popover()
    })
</script>
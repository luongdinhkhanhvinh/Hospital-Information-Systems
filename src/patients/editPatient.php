<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->viewDiag($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <?= $jumbo->getJumbo("Thêm" . $patient['firstname'] . " " . $patient['lastname'] . "Chuẩn đoán", "<a href='viewPatients.php'>Xem danh sách bệnh nhân</a>") ?>

    <form method='POST' class='editP' action='#' onsubmit="editPatient()">
        <input type="hidden" name="type" value="editPatient" id="">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>" id="">
        <div class='form-group'>
            <label for='in_Firstname'>Họ</label>
            <input name='in_Firstname' value="<?= $patient['firstname'] ?>" id='in_Firstname' class='form-control' type='text' placeholder='Họ' required>
        </div>
        <div class='form-group'>
            <label for='in_Lastname'>Tên</label>
            <input name='in_Lastname' value="<?= $patient['lastname'] ?>" id='in_Lastname' class='form-control' type='text' placeholder='Tên' required>
        </div>
        <div class='form-group'>
            <label for='in_Dob'>Ngày</label>
            <input name='in_Dob' id='in_Dob' value="<?= $patient['dob'] ?>" class='form-control' type='date' placeholder='Ngày' required>
        </div>
        <div class='form-group'>
            <label for='in_Address'>Địa chỉ</label>
            <input value='<?= $patient['address'] ?>' name='in_Address' id='in_Address' class=' form-control' rows='5' placeholder='Địa chỉ'>
        </div>
        <label for='in_Married'>Tình trạng hôn nhân</label>
        <div class='form-group'>
            <select name="in_Married" id="" class="form-control browser-default">
                <option value="<?= $patient['married'] ?>"><?= $patient['married'] ?></option>
                <option value="married">Kết hôn</option>
                <option value="single">Độc thân</option>
                <option value="divorced">Ly thân</option>
            </select>
        </div>

        <div class='form-group'>
            <label for='in_Dor'>Ngày</label>
            <input name='in_Dor' id='in_Dor' value="<?= $patient['dor'] ?>" class='form-control' type='date' placeholder='Ngày' required>
        </div>
        <div class='form-group'>
            <label for='in_Contact'>Liên hệ</label>
            <input name='in_Contact' id='in_Contact' value="<?= $patient['contact'] ?>" class='form-control' type='text' placeholder='Liên hệ' required>
        </div>
        <div class='form-group'>
            <label for='in_Referred'>Chuyển đến</label>
            <select class='form-control browser-default' value="<?= $patient['referred'] ?>" id='in_Referred' name='in_Referred' required>
                <option value="doc">Bệnh viện quận 1</option>
                <option value="doc">Bệnh viện quận 2</option>
                <option value="doc">Bệnh viện quận 3</option>
                <option value="doc">Bệnh viện quận 4</option>
                <option value="doc">Bệnh viện quận 5</option>
                <option value="doc">Bệnh viện quận 6</option>
                <option value="doc">Bệnh viện quận 7</option>
            </select>
        </div>
        <label for='in_Doctor'>Bác sĩ</label>
        <div class='form-group'>
            <select class='form-control browser-default' value="<?= $patient['doctor'] ?>" id='in_Doctor' name='in_Doctor' required>
                <option value="doc">Kim</option>
                <option value="doc">Jung</option>
                <option value="doc">Park</option>
                <option value="doc">Heong</option>
                <option value="doc">Lee</option>
                <option value="doc">Suck</option>
                <option value="doc">Teon</option>
            </select>
        </div>

        <div class='form-group'>
            <input type="submit" value="Chỉnh sửa bệnh nhân" class="btn btn-success">
        </div>
</div>

<?php include "../../includes/footer.php"; ?>


<script>
    function editPatient(e) {
        event.preventDefault();
        var form = $('.editP').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/patients/PatientsController.php',
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
                        title: "Cập nhật bệnh nhân thành công",
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
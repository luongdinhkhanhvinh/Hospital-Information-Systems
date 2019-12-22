<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
?>

<div class="container">
    <?= $jumbo->getJumbo("Thêm bệnh nhân", "Thêm chi tiết bệnh nhân") ?>
    <form method='POST' class='addP' action='#' onsubmit="addPatient()">
        <input type="hidden" name="type" value="addPatient" id="">
        <div class='form-group'>
            <label for='in_Firstname'>Họ</label>
            <input name='in_Firstname' id='in_Firstname' class='form-control' type='text' placeholder='Họ' required>
        </div>
        <div class='form-group'>
            <label for='in_Lastname'>Tên</label>
            <input name='in_Lastname' id='in_Lastname' class='form-control' type='text' placeholder='Tên' required>
        </div>
        <div class='form-group'>
            <label for='in_Dob'>Dob</label>
            <input name='in_Dob' id='in_Dob' class='form-control' type='date' placeholder='Dob' required>
        </div>
        <div class='form-group'>
            <label for='in_Address'>Địa chỉ</label>
            <textarea name='in_Address' id='in_Address' class=' form-control' rows='5' placeholder='Địa chỉ' required></textarea>
        </div>
        <label for='in_Married'>Tình trạng hôn nhân</label>
        <div class='form-group'>
            <select name="in_Married" id="" class="form-control browser-default">
                <option value="married">Kết hôn</option>
                <option value="single">Độc thân</option>
                <option value="divorced">Ly thân</option>
            </select>
        </div>
        <div class='form-group'>
            <label for='in_Contact'>Liên hệ</label>
            <input name='in_Contact' id='in_Contact' class='form-control' type='text' placeholder='Liên hệ' required>
        </div>
        <div class='form-group'>
            <input type="submit" value="Thêm bệnh nhân" class="btn btn-success">
        </div>
    </form>

    <?php include "../../includes/footer.php"; ?>

    <script>
        function addPatient(e) {
            event.preventDefault();
            var form = $('.addP').serialize();
            $.ajax({
                type: 'POST',
                url: '../../includes/patients/PatientsController.php',
                data: form,
                beforeSend: function() {
                    Swal.fire({
                        title: "Thêm bệnh nhân",
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
                            title: "Thêm bệnh nhân thành công",
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
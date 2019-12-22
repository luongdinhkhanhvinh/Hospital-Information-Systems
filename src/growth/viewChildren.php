<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
?>
<div class="container">
    <?= $jumbo->getJumbo("Xem trẻ em", "Xem danh sách trẻ em") ?>

    <?php if (isset($_GET['years'])) : ?>
        <?php $patientsList = $patients->viewAllChildrenByDate($_GET['years']); ?>
    <?php else : ?>
        <?php $patientsList = $patients->viewAllChildren();


        ?>

    <?php endif; ?>
    <form method="get">
        <input class="form-input form-control form-check form-group" placeholder="Lọc theo tuổi" type="text" name="years" id="">
    </form>
    <button onclick="refresh()" class="btn btn-default btn-sm text-left">Xóa bộ lọc</button>
    <table class="table table-responsive table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>Họ</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>Tình trạng hôn nhân</th>
            <th>Ngày đăng ký</th>
            <th>Số điện thoại</th>
            <th>Hoạt động</th>
        </thead>


        <tbody>
            <?php while ($row = $patientsList->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['dob'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['married'] ?></td>
                    <td><?= $row['dor'] ?></td>
                    <td><?= $row['contact'] ?></td>
                    <td>

                        <button type="button" class="btn btn-primary" data-toggle="popover" data-html='true' data-placement="top" title="Loại biểu đồ" data-content="
                                                <a class='btn btn-sm btn-default' href='wfa.php?id=<?= $row['user_id'] ?>'>Bệnh nhân</a><br>
                                                <a class='btn btn-sm btn-default' href='hfa.php?id=<?= $row['user_id'] ?>'>Chiều cao theo tuổi</a><br>
                                                <a class='btn btn-sm btn-default' href='wfh.php?id=<?= $row['user_id'] ?>'>Cân nặng theo chiều cao</a><br>
                                                <a class='btn btn-sm btn-default' href='bfa.php?id=<?= $row['user_id'] ?>'>BMI theo tuổi</a><br>
                                                <a class='btn btn-sm btn-default' href='hcfa.php?id=<?= $row['user_id'] ?>'>Vòng đầu theo tuổi</a><br>
                                        ">Đồ thị</button>
                    </td>
                    <td><a title="Cập nhật chi tiết" href="updateChild.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-default fa fa-pencil"></a> </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>



<?php include "../../includes/footer.php"; ?>

<script>
    function refresh() {
        window.location.href = 'viewChildren.php';
    }

    $(function() {
        $('[data-toggle="popover"]').popover()
    })
</script>
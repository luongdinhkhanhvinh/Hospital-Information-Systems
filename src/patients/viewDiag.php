<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->viewDiag($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <?= $jumbo->getJumbo("Thêm " . $patient['firstname'] . " " . $patient['lastname'] . "Chuẩn đoán", "<a href='addDiagnosis.php?id=" . $patient['user_id'] . "'>Thêm chuẩn đoán</a>") ?>

    <table class="table table-striped table-hover">
        <thead>
            <th>Tên</th>
            <th>Ngày</th>
            <th>Đơn thuốc</th>
            <th>Remarks</th>
        </thead>
        <tbody>
            <td><?= $patient['firstname'] ?> <?= $patient['lastname'] ?></td>
            <td><?= $patient['created'] ?></td>
            <td>
                <?= $patient['presp1'] ?>
            </td>
            <td><?= $patient['remarks'] ?></td>
        </tbody>
    </table>
</div>

<?php include "../../includes/footer.php"; ?>
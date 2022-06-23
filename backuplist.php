<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include "header.php";

$noti_ok = '';
$noti_error = '';
//$status_data = [['id' => 1, 'name' => 'Active'], ['id' => 2, 'name' => 'Inactive']];
if (isset($_SESSION['msg-success'])) {
    $noti_ok = $_SESSION['msg-success'];
    unset($_SESSION['msg-success']);
}


?>
<input type="hidden" class="msg-ok" value="<?= $noti_ok ?>">
<input type="hidden" class="msg-error" value="<?= $noti_error ?>">
<br>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">สำรองข้อมูล</h1>
    <div class="btn-group">
        <form action="db_backup.php" method="post">
            <input type="submit" class="btn btn-info" value="Backup Data">
        </form>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ชื่อไฟล์</th>
                        <th>วันที่</th>
                        <th>ขนาด</th>
                        <th>ดาวน์โหลด</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (glob("uploads/db_backup/*.sql") as $file): ?>
                        <tr style="vertical-align: middle">
                            <td style="vertical-align: middle"><?= basename($file) ?></td>
                            <td style="vertical-align: middle"><?= date('d/m/Y H:i:s', filectime($file)) ?></td>
                            <td style="vertical-align: middle"><?= number_format(filesize($file) / 1024, 2) . 'MB' ?></td>
                            <td style="vertical-align: middle">
                                <a href="downloadbak.php?id=<?= basename($file) ?>" class="btn btn-success">
                                    ดาวน์โหลดไฟล์</a>
                            </td>
                            <td style="vertical-align: middle">
                                <a href="deletebak.php?id=<?= basename($file) ?>" class="btn btn-danger"> ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">เรียกคืนข้อมูล</h1>
    <div class="btn-group">
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export Data</a>-->
    </div>

</div>
<div class="card shadow mb-4">
    <!--    <div class="card-header py-3">-->
    <!--        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
    <!--    </div>-->
    <div class="card-body">
        <form action="restore_db.php" method="post" enctype="multipart/form-data">
            <label for="">เลือกไฟล์ที่ต้องการกู้คืน</label>
            <input type="file" name="restore_file" accept=".sql" required><br/>
            <input type="submit" class="btn btn-info" value="Restore">
        </form>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    $(function () {
       notify();
    });
    function notify() {
        var msg_ok = $(".msg-ok").val();
        var msg_error = $(".msg-error").val();
        if (msg_ok != '') {
            $.toast({
                title: 'แจ้งเตือนการทำงาน',
                subtitle: '',
                content: msg_ok,
                type: 'success',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }
        if (msg_error != '') {
            $.toast({
                title: 'แจ้งเตือนการทำงาน',
                subtitle: '',
                content: msg_error,
                type: 'danger',
                delay: 3000,
                // img: {
                //     src: 'image.png',
                //     class: 'rounded',
                //     title: 'แจ้งการทำงาน',
                //     alt: 'Alternative'
                // },
                pause_on_hover: false
            });
        }

    }
</script>

<?php
include("header.php");
include("models/WorkorderModel.php");
include("models/WorkorderStatus.php");
include("models/ItemModel.php");
include("models/ChecklistModel.php");

$work_id = 0;

if (isset($_POST['ref_id'])) {
    $work_id = $_POST['ref_id'];
}

$work_data = getOrderIdById($connect, $work_id);
$checklist_date = [];
if($work_data){
    $checklist_date = $work_data[0]['check_list'];
}
//print_r($work_data);return;
?>
    <div class="row">
        <div class="col-lg-12">
            <h3>ปิดใบแจ้งซ่อม</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <label for="">เลขที่ใบแจ้งซ่อม</label>
            <h5><?= $work_data[0]['work_no'] ?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">วันที่</label>
            <h5><?= date('d/m/Y', strtotime($work_data[0]['work_date'])) ?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">ลูกค้า</label>
            <h5><?= $work_data[0]['customer_name'] ?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">เบอร์โทร</label>
            <h5><?= $work_data[0]['phone'] ?></h5>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-3">
            <label for="">ประเภทอุปกรณ์</label>
            <h5><?= getDeviceTypeName($work_data[0]['device_type'], $connect) ?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">ยี่ห้อ</label>
            <h5><?= getItemBrandName($work_data[0]['brand'], $connect) ?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">รุ่น</label>
            <h5><?= getItemName($work_data[0]['models'], $connect) ?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">สี</label>
            <h5><?= $work_data[0]['phone_color'] ?></h5>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <label for="">อาการแจ้งซ่อม</label>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <div class="badge badge-warning">
                <h5>
                    <?php for ($i = 0; $i <= count($checklist_date) - 1; $i++): ?>
                        <?= getChecklistname($connect, $checklist_date[$i]['check_list_id']) . ',' ?>
                    <?php endfor; ?>
                </h5>
            </div>

        </div>
    </div>
    <br/>
    <form id="form-close-work" action="close_workorder.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="workorder_id" value="<?= $work_data[0]['id'] ?><">
        <div class="row">
            <div class="col-lg-4">
                <label for="">สถานะ</label>
                <h5><?= getWorkorderStatus($work_data[0]['status']) ?></h5>
            </div>
            <div class="col-lg-4">
                <label for="">อัพโหลดวีดีโอ</label><br/>
                <input type="file" name="work_upload_file" accept="*.mp4">
            </div>
        </div>
    </form>
    <br/>
    <div class="row">
        <div class="col-lg-3">
            <div class="btn btn-success" onclick="closeworkorder()">บันทึก</div>
        </div>
    </div>
<?php
include("footer.php");
?>

<script>
    function closeworkorder(){
        if(confirm("ต้องการทำรายการนี้ใช่หรือไม่ ?")){
            $("form#form-close-work").submit();
        }
    }
</script>

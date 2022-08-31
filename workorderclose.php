<?php
include("header.php");
include("models/WorkorderModel.php");
include("models/ItemModel.php");
include("models/ChecklistModel.php");

$work_id = 0;

if(isset($_GET['id'])){
    $work_id = $_GET['id'];
}

$work_data = getOrderIdById($connect,$work_id);
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
        <h5><?=$work_data[0]['work_no']?></h5>
    </div>
    <div class="col-lg-3">
        <label for="">วันที่</label>
        <h5><?=date('d/m/Y', strtotime($work_data[0]['work_date']))?></h5>
    </div>
    <div class="col-lg-3">
        <label for="">ลูกค้า</label>
        <h5><?=$work_data[0]['customer_name']?></h5>
    </div>
    <div class="col-lg-3">
        <label for="">เบอร์โทร</label>
        <h5><?=$work_data[0]['phone']?></h5>
    </div>
</div>
<br />
    <div class="row">
        <div class="col-lg-3">
            <label for="">ประเภทอุปกรณ์</label>
            <h5><?=getDeviceTypeName($work_data[0]['device_type'],$connect)?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">ยี่ห้อ</label>
            <h5><?=getItemBrandName($work_data[0]['brand'], $connect)?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">รุ่น</label>
            <h5><?=getItemName($work_data[0]['models'], $connect)?></h5>
        </div>
        <div class="col-lg-3">
            <label for="">สี</label>
            <h5><?=$work_data[0]['phone_color']?></h5>
        </div>
    </div>
<br />
<div class="row">
    <div class="col-lg-12">
        <label for="">อาการแจ้งซ่อม</label>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <h5><?=getChecklistname($connect,$work_data[0]['models'])?></h5>
    </div>
</div>
    <br />
    <div class="row">
        <div class="col-lg-4">
            <label for="">สถานะ</label>
            <h5><?=getWOrkStatus($work_data[0]['status'])?></h5>
        </div>
        <div class="col-lg-4">
            <label for="">อัพโหลดวีดีโอ</label><br />
            <input type="file" name="work_upload_file" accept="*.mp4">
        </div>
    </div>
    <br />
<div class="row">
    <div class="col-lg-3">
        <div class="btn btn-success">บันทึก</div>
    </div>
</div>
<?php
include("footer.php");
?>
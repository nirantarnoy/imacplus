<?php
include("header.php");
include("models/MemberTypeModel.php");

$member_id = 0;
if (isset($_SESSION['userid'])) {
    $member_id = getMemberFromUser($_SESSION['userid'], $connect);
}

$data = [];

if ($member_id > 0) {
    $query = "SELECT * FROM member WHERE parent_id='$member_id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data,
            [
                'id' => $row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'member_type' => getMembertypeName($row['member_type_id'], $connect),
            ]);
    }
}

?>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <h5>ทีมงานของฉัน</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="row">
                    <?php for ($i = 0; $i <= count($data) - 1; $i++): ?>
                        <div class="col-lg-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <img src="" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><?=$data[$i]['first_name'].' '.$data[$i]['last_name']?></p>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

<?php
include("footer.php");
?>
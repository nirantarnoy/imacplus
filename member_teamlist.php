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
                'phone' => $row['phone_number'],
                'member_type' => getMembertypeName($row['member_type_id'], $connect),
            ]);
    }
}

?>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <h3><b>ทีมงานของฉัน</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                <?php for ($i = 0; $i <= count($data) - 1; $i++): ?>

                    <div class="col-lg-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center mt-2" style="text-align: center;">
                                    <div class="pos-rel">
                                        <img alt="Profile image"
                                             src="uploads/member_photo/<?= getMemberPhoto($connect, $data[$i]['id']) == '' ? 'demo.png' : getMemberPhoto($connect, $data[$i]['id']) ?>"
                                             class="radius-round bord1er-2 brc-warning-m1" style="width: 30%"/>
                                    </div>
                                    <div style="height: 10px;"></div>
                                    <span>
                                          <h5 class="text-130 text-dark-m3">
                                        <?= $data[$i]['first_name'] . ' ' . $data[$i]['last_name'] ?>
                                    </h5>
                                    </span>

                                    <span>
                                          <h5 class="text-130 text-dark-m3">
                                        <?= $data[$i]['phone'] ?>
                                    </h5>
                                    </span>

                                    <span class="d-inline-block radius-round bgc-yellow-d1 text-dark-tp3 text-150 px-25 py-3px mx-2px my-2px">
                                <?= $data[$i]['member_type'] ?>
                            </span>


                                </div>

                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>


        </div>
    </div>
<?php if ($data != null): ?>
    <br/>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <h3><b>สมาชิกชั้นที่ 2</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <?php for ($i = 0; $i <= count($data) - 1; $i++): ?>
                    <?php $data2 = getChild($connect, $data[$i]['id']); ?>
                    <?php if ($data2 != null): ?>
                        <?php for ($x = 0; $x <= count($data2) - 1; $x++): ?>
                            <div class="col-lg-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center mt-2" style="text-align: center;">
                                            <div class="pos-rel">
                                                <img alt="Profile image"
                                                     src="uploads/member_photo/<?= getMemberPhoto($connect, $data2[$x]['id']) == '' ? 'demo.png' : getMemberPhoto($connect, $data2[$x]['id']) ?>"
                                                     class="radius-round bord1er-2 brc-warning-m1" style="width: 30%"/>
                                            </div>
                                            <div style="height: 10px;"></div>
                                            <span>
                                          <h5 class="text-130 text-dark-m3">
                                        <?= $data2[$x]['first_name'] . ' ' . $data2[$x]['last_name'] ?>
                                    </h5>
                                    </span>

                                            <span>
                                          <h5 class="text-130 text-dark-m3">
                                        <?= $data2[$x]['phone'] ?>
                                    </h5>
                                    </span>

                                            <span class="d-inline-block radius-round bgc-yellow-d1 text-dark-tp3 text-150 px-25 py-3px mx-2px my-2px">
                                <?= $data2[$x]['member_type'] ?>
                            </span>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php function getChild($connect, $parent_id)
{
    $data = [];
    if ($parent_id > 0) {
        $query = "SELECT * FROM member WHERE parent_id='$parent_id' ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            array_push($data,
                [
                    'id' => $row['id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone' => $row['phone_number'],
                    'member_type' => getMembertypeName($row['member_type_id'], $connect),
                ]);
        }
    }
    return $data;
}

?>
<?php
include("footer.php");
?>
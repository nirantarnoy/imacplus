<?php

include("header.php");
include("models/WorkorderModel.php");
$workorder_data = getWorkorderData($connect, $_SESSION['userid']);

//print_r($notify_data);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">สถานะการแจ้งซ่อม</h1>

</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <?php if (count($workorder_data) > 0): ?>
            <?php for ($i = 0; $i <= count($workorder_data) - 1; $i++): ?>
                <a href="worktrack.php?id=<?= $workorder_data[$i]['id'] ?>" method="get">
                <div class="alert fade show bgc-white brc-secondary-l2 rounded" role="alert">
                    <div class="position-tl h-102 border-l-4 brc-danger m-n1px rounded-left"></div>
                    <!-- the big red line on left -->

                    <h5 class="alert-heading text-success-m1 font-bolder">
                        <i class="fas fa-check-circle mr-1 mb-1"></i>
                        <?= $workorder_data[$i]['work_no'] ?>
                    </h5>

                    <!--                    --><? //=$notify_data[$i]['work_date']?>
                    <!--            <a href="#" class="alert-link text-danger-m2">-->
                    <!--                an example link-->
                    <!--            </a>.-->

                    <!--                    <p class="mt-3 mb-0">-->
                    <!--                        <button class="btn btn-link text-primary font-bolder py-0 px-2" data-dismiss="alert"-->
                    <!--                                aria-label="Close">-->
                    <!--                            อ้างอิงเลขที่ 220810-00001-->
                    <!--                        </button>-->
                    <!--                    </p>-->

                    <p class="my-1">
                        <button class="btn btn-link text-secondary-d2 font-bolder py-0 px-2" data-dismiss="alert"
                                aria-label="Close">
                            วันที่ <?= date('d-m-Y H:i:s', strtotime($workorder_data[$i]['work_date'])) ?>
                        </button>
                    </p>
                    <p class="my-1">
                        <button class="btn btn-link text-secondary-d2 font-bolder py-0 px-2" data-dismiss="alert"
                            aria-label="Close">
                            สถานะ <span style="color: blue"><?= getWOrkStatus($workorder_data [$i]['status']) ?></span>
                        </button>
                    </p>
                </div>
                </a>
            <?php endfor; ?>
        <?php endif; ?>

    </div>
</div>
<?php
include("footer.php");
?>

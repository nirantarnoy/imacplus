<?php

include("header.php");
//include("models/MemberModel.php");
$notify_data = getMemberNotify($connect, $_SESSION['userid']);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">แจ้งเตือน</h1>

</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <?php if (count($notify_data) > 0): ?>
            <?php for ($i = 0; $i <= count($notify_data) - 1; $i++): ?>
                <div class="alert fade show bgc-white brc-secondary-l2 rounded" role="alert">
                    <div class="position-tl h-102 border-l-4 brc-danger m-n1px rounded-left"></div>
                    <!-- the big red line on left -->

                    <h5 class="alert-heading text-success-m1 font-bolder">
                        <i class="fas fa-check-circle mr-1 mb-1"></i>
                        <?=$notify_data[$i]['title']?>
                    </h5>

                   <?=$notify_data[$i]['detail']?>
                    <!--            <a href="#" class="alert-link text-danger-m2">-->
                    <!--                an example link-->
                    <!--            </a>.-->

                    <p class="mt-3 mb-0">
                        <button class="btn btn-link text-primary font-bolder py-0 px-2" data-dismiss="alert"
                                aria-label="Close">
                            อ้างอิงเลขที่ 220810-00001
                        </button>
                    </p>

                    <p class="my-1">
                        <button class="btn btn-link text-secondary-d2 font-bolder py-0 px-2" data-dismiss="alert"
                                aria-label="Close">
                            วันที่ <?= date('d-m-Y H:i:s', strtotime($notify_data[$i]['message_date'])) ?>
                        </button>
                    </p>
                </div>
            <?php endfor; ?>
        <?php endif; ?>

    </div>
</div>
<?php
include("footer.php");
?>

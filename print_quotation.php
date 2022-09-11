<?php
include('header.php');
include('models/ItemModel.php');
include("models/ChecklistModel.php");
include("models/WorkorderModel.php");

$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$quotation_line = [];
$quotation_id = 0;
$quotation_no = '';
$quotation_date = '';
$customer_id = '';
$customer_name = '';
$customer_phone = '';
$workorder_id = 0;
$status = 0;

if ($id > 0) {
    $query = "SELECT * FROM quotation WHERE id ='$id'";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
//$filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $quotation_id = $row['id'];
        $quotation_no = $row['quotation_no'];
        $quotation_date = $row['quotation_date'];
        $customer_id = $row['customer_id'];
        $customer_name = $row['customer_name'];
        $customer_phone = '';
        $workorder_id = $row['workorder_id'];
        $status = $row['status'];

    }

    $query2 = "SELECT * FROM quotation_line WHERE quotation_id ='$id'";

    $statement2 = $connect->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach ($result2 as $row2) {
        array_push($quotation_line, [
            'id' => $row2['id'],
            'item_id' => $row2['item_id'],
            'item_name' => $row2['item_name'],
            'price' => $row2['price'],
            'qty' => $row2['qty'],
            'line_total' => $row2['line_total'],
        ]);
    }
}


?>
<div id="print-area">

    <input type="hidden" id="rec-id" value="<?= $id ?>">
    <table style="width: 100%;border: none;">
        <tr>
            <td colspan="2" style="text-align: center;"><h3>ใบเสนอราคาซ่อม</h3></td>

        </tr>
        <tr>
            <td style="text-align: left;">เลขที่ &nbsp; &nbsp; <b><?= $quotation_no ?></b></td>
            <td style="text-align: right;">วันที่ &nbsp; &nbsp; <b><?= date('d-m-Y', strtotime($quotation_date)) ?></b>
            </td>
        </tr>


    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%">ชื่อลูกค้า &nbsp; &nbsp; <b><?= $customer_name ?></b></td>

            <td style="width: 50%">โทรศัพท์ติดต่อ &nbsp; &nbsp; <b><?= $customer_phone ?></b></td>

        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%">อ้างอิงเลขที่แจ้งซ่อม &nbsp; &nbsp; <b><?=getWorkorderNo($connect, $workorder_id) ?></b></td>

            <td style="width: 50%"></td>

        </tr>
    </table>

    <br/>

    <h5>รายละเอียด</h5>

    <table class="table" style="border: 1px solid grey;">
        <thead>
        <tr>
            <th style="width: 5%;border: 1px solid grey;text-align: center;">#</th>
            <th style="border: 1px solid grey;">รายการ</th>
            <th style="text-align: right;border: 1px solid grey;">จำนวน</th>
            <th style="text-align: right;border: 1px solid grey;">ราคาต่อหน่วย</th>
            <th style="text-align: right;border: 1px solid grey;">รวม</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $x=0;
        $total = 0;
        ?>
        <?php for($i=0;$i<=count($quotation_line)-1;$i++):?>
            <?php
            $x+=1;
            $total = ($total + $quotation_line[$i]['line_total']);
            ?>
        <tr>
            <td style="width: 5%;border: 1px solid grey;text-align: center;"><?=$x?></td>
            <td style="border: 1px solid grey;"><?=$quotation_line[$i]['item_name']?></td>
            <td style="text-align: right;border: 1px solid grey;"><?=$quotation_line[$i]['qty']?></td>
            <td style="text-align: right;border: 1px solid grey;"><?=number_format($quotation_line[$i]['price'],2)?></td>
            <td style="text-align: right;border: 1px solid grey;"><?=number_format($quotation_line[$i]['line_total'],2)?></td>
        </tr>
        <?php endfor;?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" style="text-align: right;border: 1px solid grey;"><b>รวม</b></td>
            <td style="text-align: right;font-weight: bold;border: 1px solid grey;"><?=number_format($total,2)?></td>
        </tr>
        </tfoot>
    </table>

</div>
<br/>
<div class="row">
    <div class="col-lg-8">
        <?php if($status != 1):?>
        <form id="form-confirm" action="quotation_action.php" method="post">
            <input type="hidden" name="action_type" value="confirm">
            <input type="hidden" name="quotation_confirm_id" value="<?=$quotation_id?>">
            <div class="btn btn-success" onclick="quotationaccept()">ยอมรับและยืนยัน</div>
        </form>
       <?php endif;?>
    </div>
    <div class="col-lg-4" style="text-align: right;">
        <div class="btn btn-info" onclick="printContent('print-area')">พิมพ์</div>
        <!--        <div class="btn btn-info" onclick="printPage('print_work_doc.php')">พิมพ์</div>-->
    </div>
</div>
<?php
include('footer.php');
?>
<script>
    calcheck();

    function calcheck() {
        var recid = $("#rec-id").val();
        var checklist = null;
        // alert(recid);
        if (recid > 0) {
            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'url': 'get_workorder_update.php',
                'data': {'id': recid},
                'success': function (data) {

                    if (data.length > 0) {
                        checklist = data[0]['check_list'];
                    }
                },
                'error': function (err) {
                    alert('ee');
                }
            });
            if (checklist.length > 0) {
                $(".checklist").each(function () {

                    var id_value = $(this).attr("data-value");
                    for (var x = 0; x <= checklist.length - 1; x++) {
                        if (id_value == checklist[x]['check_list_id']) {
                            //   alert();
                            $(this).removeClass("fa-circle");
                            $(this).addClass("fa-check-circle");
                            $(this).addClass("text-dark");
                        }
                    }
                    // console.log('xx');
                });

            }
        }

    }

    function quotationaccept(){
        if(confirm("ต้องการยืนยันการทำรายการใช่หรือไม่ ?")){
            $("form#form-confirm").submit();
        }
    }

    function closePrint() {
        document.body.removeChild(this.__container__);
    }

    function setPrint() {
        this.contentWindow.__container__ = this;
        this.contentWindow.onbeforeunload = closePrint;
        this.contentWindow.onafterprint = closePrint;
        this.contentWindow.focus(); // Required for IE
        this.contentWindow.print();
    }

    function printPage(sURL) {
        $(".print-copy").show();
        const hideFrame = document.createElement("iframe");
        hideFrame.onload = setPrint;
        hideFrame.style.position = "fixed";
        hideFrame.style.right = "0";
        hideFrame.style.bottom = "0";
        hideFrame.style.width = "0";
        hideFrame.style.height = "0";
        hideFrame.style.border = "0";
        hideFrame.src = sURL;
        document.body.appendChild(hideFrame);
    }

    function printContent(el) {
        $(".print-copy").show();
        // var css= '<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">';
        // document.head.innerHTML = css;
        // var restorepage = document.body.innerHTML;
        // var printcontent = document.getElementById(el).innerHTML;
        // document.body.innerHTML = printcontent;
        // window.print();
        // document.body.innerHTML = restorepage;


        // var css= '<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">';
        // var printContent = document.getElementById(el);
        //
        // var WinPrint = window.open('', '', 'width=900,height=900');
        // WinPrint.document.write(printContent.innerHTML);
        // WinPrint.document.head.innerHTML = css;
        // WinPrint.document.close();
        // WinPrint.focus();
        // WinPrint.print();
        // WinPrint.close();

        var contents = $("#print-area").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        //  frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>DIV Contents</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.


        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/regular.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/brands.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="node_modules/@fortawesome/fontawesome-free/css/solid.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="dist/css/ace-font.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="dist/css/ace.css">');
        frameDoc.document.write('<link rel="stylesheet" type="text/css" href="mycss.css">');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);

    }
</script>

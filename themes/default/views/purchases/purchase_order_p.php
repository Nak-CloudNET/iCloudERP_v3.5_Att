<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <title> Purchase Order </title>
    <style>
        .header table tr{
            line-height: 5px;
        }

        fieldset {
            border:1px solid black;
            border-radius: 7px;
            height: 100%;
            margin: 8px;

            padding: 8px;

        }


        legend {
            padding: 2px;
            font-size: 20px;
            font-weight: bold;
            width:inherit; /* Or auto */
            padding:0 10px; /* To give a bit of padding on the left and right */
            border-bottom:none;
        }
        fieldset p{
            line-height: 5px;
            font-size: 12px;
        }
        .th_text{
            font-size: 12px;
        }
        .tr_cus{

        }
        .cus_tb{
            border-color: black;
        }
        .cus_tb>thead>tr>th{
            border-color: black;
            background:lightgrey;
            color: #0000BB;
            padding: 2px 0px;
            border-top-style: double;


        }
        .tr_foot{

            border: none;

        }
        hr{
            height: 5px;
            background:#0e90d2;
        }

        .hr_cus{
            color: #0e90d2;
            font-size: 20px;
        }
        .lr{
            height: 1px;
            background: #0e90d2;
            margin-top: 15px;
            border: 3px solid #0e90d2;
        }

        @media print {
            legend {

                background: white;
            }
            hr{
                height: 5px!important;
                background:#0e90d2!important;
                color: #0000BB;
                font-size: 100px;
            }
            .lr{
                background: #0e90d2;

                margin-top: 20px;
            }
        }
        .tb_fs{
            font-size: 13px;
        }
        .tr_foot{
            padding: 15px 0px;
        }
        .text-right{
            border-color: black;
            color: #0000BB;
        }

    </style>

</head>
<body>

<div>
    <br>
</div>
<div class="header " >

    <table width="100%" class="text-center ">
        <tr>
            <td><h3><?= $billers->company;?></h3></td>

        </tr>
        <tr>

            <td><br><br><p style="font-size: 13px;"><?= $billers->address ?></p></td>
        </tr>
        <tr>
            <td><p style="font-size: 13px;">
                    <?php
                    if($billers->phone){
                        echo lang("tel")."&nbsp;&nbsp;:&nbsp;&nbsp;".$billers->phone.",";
                    }
                    if ($billers->email) {
                        echo lang("email")."&nbsp;&nbsp;:&nbsp;&nbsp;".$billers->email;
                    }
                    ?>
                </p></td>
        </tr>

    </table>

    <div class="col-lg-12 col-md-12 col-sm-12 " >
        <div class="row r1">
            <div class="col-lg-7 col-md-7 col-sm-7 lr">

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 lr2 text-center">
                <h4 ><i>PURSCHASE ORDER</i></h4>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 lr">

            </div>
        </div>
    </div>

    <!--
    <table width="100%">
          <tr>
              <td width="65%">
                  <hr class="hr-head" >
              </td>
              <td width="30%" class="text-center">

              </td>
              <td width="5%">
                  <hr class="hr-head">
              </td>
          </tr>
      </table>
  -->


</div>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <fieldset>
                <legend >Purpose of Request</legend>
                <table class="tb_fs">
                    <tr>
                        <td><p>Supplier Name</p></td>
                        <td><p>&nbsp;:&nbsp;<b><?=$supplier->name?></b></p></td>
                    </tr>
                    <tr>
                        <td><p>Address: </p></td>
                        <td><p>&nbsp;:&nbsp;<b><?=$supplier->address?></b></p></td>
                    </tr>
                    <tr>
                        <td><p>Phone: </p></td>
                        <td><p>&nbsp;:&nbsp;<b><?=$supplier->phone?></b></p></td>
                    </tr>

                </table>



            </fieldset>


        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 " >
            <fieldset>
                <legend>Reference</legend>
                <table>

                        <?php if ($invs->reference_no) { ?>
                            <tr>
                                <td>
                                    <p>PR N<sup>o</sup></p>
                                </td>

                                <td>
                                    <p>&nbsp;:&nbsp;<b><?= $invs->reference_no ?></b></p>
                                </td>

                            </tr>
                    <?php } ?>
                    <tr>
                        <td>
                            <p>Date</p>
                        </td>

                        <td>
                            <p>&nbsp;:&nbsp;<b><?= $this->erp->hrld($invs->date); ?></b></p>
                        </td>

                    </tr>

                </table>







            </fieldset>
        </div>
    </div>
</div>

<br><br>
<div  class="col-lg-12 col-md-12 col-sm-12">
    <table width="100%"  class="text-center  cus_tb">
        <thead>
        <tr class="th_text" >
            <th style="border-left-style: double;">N<sup>o</sup></th>
            <th style="border-right:1px solid black;border-left:1px solid black">ITEM CODE</th>
            <th style="border-right:1px solid black">ITEM DESCRIPTION</th>

            <th style="border-right:1px solid black">QTY</th>
            <th style="border-right:1px solid black">UNIT</th>
            <th style="border-right:1px solid black">REQ.DATE</th>
            <th style="border-right:1px solid black">LOCATION</th>
            <th style="border-right:1px solid black">COST</th>
            <th style="border-right-style: double;">AMOUNT</th>
        </tr>
        </thead>
        <tbody>

        <?php

        $no = 1;
        $erow = 1;
        $totalRow = 0;
        foreach ($rows as $row) {
            $free = lang('free');
            $product_unit = '';
            $total = 0;

            if($row->variant){
                $product_unit = $row->variant;
            }else{
                $product_unit = $row->uname;
            }
            $product_name_setting;
            if($setting->show_code == 0) {
                $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
            }else {
                if($setting->separate_code == 0) {
                    $product_name_setting = $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : '');
                }else {
                    $product_name_setting = $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                }
            }

            ?>


            <tr class="tr_cus" style="border-top: 1px dashed black;">
                <td style="border-left-style: double;"><?= @$no; ?></td>
                <td style="border-right:1px dashed black;border-left:1px solid black" class="text-left">&nbsp;<?=$row->product_code?></td>
                <td class="text-left">&nbsp;<?=$row->product_name;?></td>
                <td style="border-right:1px dashed black;border-left:1px dashed black"><?=$this->erp->formatQuantity($row->po_qty);?></td>
                <td style="border-right:1px dashed black"><?php if($row->variant){ echo $row->variant;}else{echo $row->unit;}?></td>
                <td style="border-right:1px dashed black"><?= $row->date; ?></td>
                <td style="border-right:1px dashed black"><?= $row->warehouse_name; ?></td>
                <td style="border-right:1px dashed black;color: black;" class="text-right"><?= $this->erp->formatMoney($row->unit_cost); ?>&nbsp;</td>
                <td style="border-right-style: double; width: 20%; " class="text-right" ><b><?= @$this->erp->formatMoney($row->subtotal); ?></b>&nbsp;</td>
            </tr>

            <?php
            $no++;
            $erow++;
            $totalRow++;
//                    if ($totalRow % 25 == 0) {
//                        echo '<tr class="pageBreak"></tr>';
//                    }

        }
        ?>

        <tr style="border-top-style: double;">
            <td   style="border-bottom: none;  " colspan="7" rowspan="3">
                <fieldset class="text-left" style="height: 70px;">
                    <legend style="font-size: 13px">Note</legend>
                    <p><?php echo strip_tags(htmlspecialchars_decode($invs->note)); ?></p>
                </fieldset>
            </td>

            <style>
                .cel-cus{
                    position: relative;
                }
                .cel-cus::after{
                    position: absolute;
                    content: "";
                    border-color: black;
                    height: 100%;
                    top:-1px;
                    left: -1px;
                    border-left-style: double;
                }
            </style>

            <td style="" class=" text-right cel-cus" ><b>Total:&nbsp;&nbsp;</b></td>
            <td style="border-left:1px dashed black; border-right-style: double; " class="text-right"><b><?= @$this->erp->formatMoney($invs->total);?>&nbsp;</b></td>

        </tr>
        <tr style="border-top:1px dashed black;">



            <td style="border-left-style: double; border-bottom-style:double " class="text-right" ><b>Grand Total:&nbsp;</b></td>
            <td style="border-left:1px dashed black; border-right-style: double; border-bottom-style: double" class="text-right"><b><?= @$this->erp->formatMoney($invs->grand_total);?>&nbsp;</b></td>

        </tr>
        <tr>
            <td style=" "> &nbsp;</td>
            <td> </td>
        </tr>



    </table>
</div>
<br><br>
<div class="row">
    <div  class="col-lg-12col-md-12 col-sm-12">
        <table width="100%" class="text-center" style="font-size: 13px">
            <tr>
                <td>Request by</td>
                <td>Approve by</td>
            </tr>
            <tr>
                <td></td>
                <td><br><br></td>
            </tr>
            <tr >
                <td class="hr_cus">________________________</td>
                <td class="hr_cus">________________________</td>
            </tr>
            <tr>
                <td>Name: ...............................................</td>
                <td>Name: ...............................................</td>
            </tr>
            <tr>
                <td>Date: ............../................../..............</td>
                <td>Date: ............./................../...............</td>
            </tr>
        </table>
    </div>

</div>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

</html>

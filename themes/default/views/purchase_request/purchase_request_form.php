<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <title>Purchase Request</title>
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
    </style>

</head>
<body>
<?php



foreach ($purchase_r->result() as $item1){

    $re_num=$item1->reference_no;
    $re_date=$item1->date;
    $re_des=$item1->note;
    $company=$item1->company;
    $c_name=$item1->company;
    $c_addr=$item1->address;
    $c_phone=$item1->phone;
    $c_email=$item1->email;
}


?>
<div>
    <br>
</div>
<div class="header " >

    <table width="100%" class="text-center ">
        <tr>
            <td><h3><?=  @$c_name; ?></h3></td>

        </tr>
        <tr>

            <td><br><br><p style="font-size: 13px;"><?= @$c_addr; ?></p></td>
        </tr>
        <tr>
            <td><p style="font-size: 13px;"><?php
                    if($c_phone){
                        echo lang("tel")."&nbsp;&nbsp;:&nbsp;&nbsp;".$c_phone.",";
                    }
                    if ($c_email) {
                        echo lang("email")."&nbsp;&nbsp;:&nbsp;&nbsp;".$c_email;
                    }
                    ?></p></td>
        </tr>

    </table>

    <div class="col-lg-12 col-md-12 col-sm-12 " >
        <div class="row r1">
            <div class="col-lg-7 col-md-7 col-sm-7 lr">

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 lr2 text-center">
                            <h4 ><i>PURSCHASE REQUESITION</i></h4>
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
                        <td><p>Project Name</p></td>
                        <td><p>&nbsp;:&nbsp;<b><?= @$company; ?></b></p></td>
                    </tr>
                    <tr>
                        <td><p>Description: </p></td>
                        <td>

                           <?php

                                if($re_des){
                                    $des=str_replace('&lt;/p&gt;','',$re_des);
                                    $des=str_replace('&lt;p&gt;','',$des);
                                    echo ' <p>&nbsp;:&nbsp;<b>'.$des.'</b></p>';
                                }
                                else{
                                    echo '&nbsp;:&nbsp;<p></p>';
                                }

                            ?>

                        </td>
                    </tr>

                </table>



            </fieldset>


        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 " >
            <fieldset>
                <legend>Reference</legend>
                <table>
                    <tr>
                        <td><p>PR.Number</p></td>
                        <td><p>&nbsp;:&nbsp;<b><?= @$re_num;?></b></p></td>
                    </tr>
                    <tr>
                        <td><p>PR.Date:</p></td>
                        <td><p>&nbsp;:&nbsp;<b><?= @$re_date; ?></b></p></td>
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
                <th style="border-left-style: double;">No</th>
                <th style="border-right:1px solid black;border-left:1px solid black">ITEM CODE</th>
                <th style="border-right:1px solid black">DESCRIPTION</th>
                <th style="border-right:1px solid black">REMARK</th>
                <th style="border-right:1px solid black">QHO</th>
                <th style="border-right:1px solid black">QTY</th>
                <th style="border-right:1px solid black">UNIT</th>
                <th style="border-right:1px solid black">LOCATION</th>
                <th style="border-right:1px solid black">EST.PRICE</th>
                <th style="border-right-style: double;">TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($purchase_product->result() as $it){

                $i+=1;
                $p_code=$it->product_code;
                $p_n=$it->product_name;
                $remark=$it->note;
                $qho=$this->erp->formatQuantity($it->wqty);
                $qty=$this->erp->formatQuantity($it->quantity);
                $unit=$it->unit;
                $warehouse=$it->wname;
                $price=$it->unit_cost;
                $subtotal=$qty*$price;
                $total+=$subtotal;

                ?>

                <tr class="tr_cus" style="border-top: 1px dashed black;">
                    <td style="border-left-style: double;"><?= @$i; ?></td>
                    <td style="border-right:1px dashed black;border-left:1px solid black"><?= @$p_code; ?></td>
                    <td class="text-left"><?= @$p_n; ?></td>
                    <td class="text-left"><?= @$remark; ?></td>
                    <td style="border-right:1px dashed black"><?= @$qho; ?></td>
                    <td style="border-right:1px dashed black"><?= @$qty; ?></td>
                    <td style="border-right:1px dashed black"><?= @$unit; ?></td>
                    <td style="border-right:1px dashed black"><?= @$warehouse; ?></td>
                    <td style="border-right:1px dashed black"><?= @$this->erp->formatMoney($price);  ?></td>
                    <td style="border-right-style: double;"><?= @$this->erp->formatMoney($subtotal); ?></td>
                </tr>

           <?php
            }
            ?>

                <tr class="tr_foot" style="border-top-style: double;">
                    <td colspan="8" style="border-bottom: none; border-left: none;"></td>
                    <td style="border-left-style: double; border-bottom-style:double ">Total</td>
                    <td style="border-left:1px dashed black; border-right-style: double; border-bottom-style: double"><?= @$this->erp->formatMoney($total);?></td>
                </tr>
        </tbody>


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

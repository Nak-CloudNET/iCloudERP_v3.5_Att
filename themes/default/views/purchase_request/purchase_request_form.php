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
        .cus_tb>thead>tr>th{
            background:lightgrey;
            color: #0000BB;
            padding: 2px 0px;
        }
        .cus_tb>tbody>tr>td,.cus_tb>thead>tr>th{
            border:1px solid black;
        }
        .hr_cus{
            color: #0e90d2;
            font-size: 20px;
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
}


?>
<div class="header ">
    <table width="100%" class="text-center">
        <tr>
            <td><h3><?=  @$c_name; ?></h3></td>

        </tr>
        <tr>

            <td><br><br><p style="font-size: 13px;"><?= @$c_addr; ?></p></td>
        </tr>
        <tr>
            <td><p style="font-size: 13px;">Tel: <?= @$c_phone; ?></p></td>
        </tr>

    </table>
    <table width="100%">
        <tr>
            <td width="65%">
                <hr style=" height: 5px; background:#0e90d2;">
            </td>
            <td width="30%" class="text-center">
                <h3 ><i>PURSCHASE REQUESITION</i></h3>
            </td>
            <td width="5%">
                <hr style=" height: 5px; background:#0e90d2;">
            </td>
        </tr>
    </table>

</div>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <fieldset>
                <legend>Purpose of Request</legend>
                <table>
                    <tr>
                        <td><p>Project Name: </p></td>
                        <td><p> <?= @$company; ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Description: </p></td>
                        <td><p> <?= @$re_des; ?></p></td>
                    </tr>
                </table>



            </fieldset>


        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 " >
            <fieldset>
                <legend>Reference</legend>
                <table>
                    <tr>
                        <td><p>PR.Number:</p></td>
                        <td><p><?= @$re_num;?></p></td>
                    </tr>
                    <tr>
                        <td> <p>PR.Date:</p></td>
                        <td><p><?= @$re_date; ?></p></td>
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
            <tr class="th_text">
                <th>No</th>
                <th>ITEM CODE</th>
                <th>DESCRIPTION</th>
                <th>REMARK</th>
                <th>QHO</th>
                <th>QTY</th>
                <th>UNIT</th>
                <th>LOCATION</th>
                <th>EST.PRICE</th>
                <th>TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($purchase_product->result() as $it){

                $i+=1;
                $p_code=$it->product_code;
                $p_n=$it->product_name;
                $remark='unknown';
                $qho=$it->wqty;
                $qty=$it->quantity;
                $unit=$it->unit;
                $warehouse=$it->wname;
                $price=$it->price;
                $subtotal=$qty*$price;
                $total+=$subtotal;

                ?>

                <tr>
                    <td><?= @$i; ?></td>
                    <td><?= @$p_code; ?></td>
                    <td><?= @$p_n; ?></td>
                    <td><?= @$remark; ?></td>
                    <td><?= @$qho; ?></td>
                    <td><?= @$qty; ?></td>
                    <td><?= @$unit; ?></td>
                    <td><?= @$warehouse; ?></td>
                    <td><?= @$price; ?></td>
                    <td><?= @$subtotal; ?></td>
                </tr>

           <?php }
            ?>

                <tr>
                    <td colspan="8" style="border-bottom: none; border-left: none;"></td>
                    <td>Total</td>
                    <td><?= @$total; ?></td>
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

<?php
	$v = "";
	
	if ($this->input->post('start_date')) {
		$v .= "&start_date=" . $this->input->post('start_date');
	}
	if ($this->input->post('end_date')) {
		$v .= "&end_date=" . $this->input->post('end_date');
	}
	if(isset($date)){
		$v .= "&d=" . $date;
	}

?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
        $("#product").autocomplete({
            source: '<?= site_url('reports/suggestions'); ?>',
            select: function (event, ui) {
                $('#product_id').val(ui.item.id);
                //$(this).val(ui.item.label);
            },
            minLength: 1,
            autoFocus: false,
            delay: 300,
        });
    });
</script>
<?php
	echo form_open('reports/saleman_actions', 'id="action-form"');
?>

<div class="box">
    <div class="box-header">
        <h2 class="blue">
			<i class="fa-fw fa fa-heart"></i><?=lang('saleman_report'); ?>
			<?php 
				if ($this->input->post('start_date')) {
					echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
				}
			?>
        </h2>
		<div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?=lang("actions")?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fa fa-file-excel-o"></i> <?=lang('export_to_excel')?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="pdf" data-action="export_pdf">
                                <i class="fa fa-file-pdf-o"></i> <?=lang('export_to_pdf')?>
                            </a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </div>

    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>

	<div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?=lang('list_results');?></p>
				<div id="form">

                    <?php echo form_open("reports/saleman"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                <?php
                                $bl[""] = "";
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ''), 'class="form-control datetime" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ''), 'class="form-control datetime" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="SLData" class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
							<tr>
								<th style="width: 3% !important; text-align: center;">
									<input class="checkbox checkth input-xs" type="checkbox" name="check"/>
								</th>
								<th><?php echo $this->lang->line("saleman_name"); ?></th>
								<th><?php echo $this->lang->line("email"); ?></th>
								<th><?php echo $this->lang->line("phone_number"); ?></th>
								<th><?php echo $this->lang->line("amount"); ?></th>
								<th><?php echo $this->lang->line("paid"); ?></th>
								<th><?php echo $this->lang->line("return"); ?></th>
								<th><?php echo $this->lang->line("deposit"); ?></th>
								<th><?php echo $this->lang->line("discount"); ?></th>
                                <th><?php echo $this->lang->line("balance"); ?></th>
								<th><?php echo $this->lang->line("actions"); ?></th>
							</tr>
                        </thead>
                        <tbody>
                        <?php
						if ($this->input->POST('biller')) {
							$biller = $this->input->POST('biller');
						} else {
							$biller = NULL;
						}
						$datt =$this->reports_model->getLastDate("sales","date");
						if ($this->input->POST('start_date')) {
							$start_date =  $this->erp->fsd($this->input->POST('start_date'));
						} else {
							$start_date = NULL;
						}
						if ($this->input->POST('end_date')) {
							$end_date =  $this->erp->fsd($this->input->POST('end_date'));
						} else {
							$end_date = NULL;
						}
						
						
						$wheres = "";
						$sdv = $this->db;
                        $sdv->select("username, phone, id, email")->from('users u');
						/*if($this->session->userdata('biller_id') != NULL){
							$sdv->where('u.biller_id', $this->session->userdata('biller_id'));
						}*/
						$query = $sdv->get()->result();
						$i = 1;
						$tAmount 	= 0;
						$tPaid		= 0;
						$tReturn    = 0;
						$tDeposit   = 0;
						$tDiscount  = 0;
						$sBalance   = 0;
						$tbalance	= 0;
						foreach ($query as $rows) {
							$sale = $this->db->select($this->db->dbprefix('sales').".id as id,
				                        ".$this->db->dbprefix('sales').".date,
				                        ".$this->db->dbprefix('payments').".date as pdate,
				                        ".$this->db->dbprefix('sales').".reference_no, biller.company, ".$this->db->dbprefix('sales').".customer,
										sale_status, ".$this->db->dbprefix('sales').".grand_total,
										COALESCE((SELECT SUM(erp_return_sales.paid) FROM erp_return_sales WHERE erp_return_sales.sale_id = erp_sales.id), 0) as return_sale,
										COALESCE((SELECT SUM(IF((erp_payments.paid_by != 'deposit' AND ISNULL(erp_payments.return_id)), erp_payments.amount, IF(NOT ISNULL(erp_payments.return_id), ((-1)*erp_payments.amount), 0))) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id),0) as paid,
										COALESCE((SELECT SUM(IF(erp_payments.paid_by = 'deposit', erp_payments.amount, 0)) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id), 0) as deposit,
										COALESCE((SELECT SUM(erp_payments.discount) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id), 0) as discount,
										(" . $this->db->dbprefix('sales') . ".grand_total - COALESCE((SELECT SUM(erp_return_sales.paid) FROM erp_return_sales WHERE erp_return_sales.sale_id = erp_sales.id), 0) - COALESCE((SELECT SUM(IF((erp_payments.paid_by != 'deposit' AND ISNULL(erp_payments.return_id)), erp_payments.amount, IF(NOT ISNULL(erp_payments.return_id), ((-1)*erp_payments.amount), 0))) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id),0) - COALESCE((SELECT SUM(IF(erp_payments.paid_by = 'deposit', erp_payments.amount, 0)) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id), 0) - COALESCE((SELECT SUM(erp_payments.discount) FROM erp_payments WHERE erp_payments.sale_id = erp_sales.id), 0)) as balance,
										sales.payment_status")
                                ->from('sales')
                                ->join('payments', 'payments.sale_id=sales.id', 'left')
                                ->join('erp_return_sales', 'erp_return_sales.sale_id = sales.id', 'left')
                                ->join('companies', 'companies.id=sales.customer_id', 'left')
                                ->join('companies as erp_biller', 'biller.id = sales.biller_id', 'inner')
                                ->where('sales.saleman_by',$rows->id)
                                ->group_by('sales.id');
							if($biller){
								$this->db->where('biller_id', $biller);
							}
							if($start_date){
							    $this->db->where('date_format(date,"%Y-%m-%d") BETWEEN "'.$start_date.'" AND "'.$end_date.'" ');
							}           
                            $sales = $sale->get()->result();							
							$samount 	        = 0;
							$spaid		        = 0;
							$sreturn_sale       = 0;
							$sdeposit_payment   = 0;
							$sdiscount_payment  = 0;

                            //$this->erp->print_arrays($query);
							foreach($sales as $rw)
							{
								$samount 	        += $rw->grand_total;
								$spaid		        += $rw->paid;
                                $sreturn_sale       += $rw->return_sale;
                                $sdeposit_payment   += $rw->deposit;
                                $sdiscount_payment  += $rw->discount;
							}
                            $sBalance   = ($samount - ($spaid + $sreturn_sale + $sdeposit_payment + $sdiscount_payment));
						   ?>
							<tr class="active">
								<td style="width: 3% !important; text-align: center;">
									<input class="checkbox multi-select input-xs" type="checkbox" name="val[]" value="<?= $rows->id?>" />
								</td>
								<td><?= ucwords($rows->username) ?></td>
								<td><?=$rows->email?></td>
								<td><?=$rows->phone?></td>
								<td class="text-right"><?= $samount ? $this->erp->formatMoney($samount) : '' ?></td>
								<td class="text-right"><?= $spaid ? $this->erp->formatMoney($spaid) : '' ?></td>
								<td class="text-right"><?= $sreturn_sale ? $this->erp->formatMoney($sreturn_sale) : '' ?></td>
								<td class="text-right"><?= $sdeposit_payment ? $this->erp->formatMoney($sdeposit_payment) : '' ?></td>
								<td class="text-right"><?= $sdiscount_payment ? $this->erp->formatMoney($sdiscount_payment) : '' ?></td>
                                <td class="text-right"><?= $sBalance ? $this->erp->formatMoney($sBalance) : '' ?></td>
								<td class="text-center"><a href="<?= site_url('reports/view_saleman_report/' . $rows->id) ?>"><span class='label label-primary'><?= lang('view_report') ?></span></a></td>
							</tr>
						   <?php
							$tAmount	+= $samount;
							$tPaid		+= $spaid;
							$tReturn    += $sreturn_sale;
							$tDeposit   += $sdeposit_payment;
							$tDiscount  += $sdiscount_payment;
							$tbalance	+= $sBalance;
						}
						?>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="width: 3% !important; text-align: center;">
                                <input class="checkbox checkft input-xs" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang('saleman_name')?></th>
                            <th><?= lang('email')?></th>
                            <th><?= lang('phone_number')?></th>
                            <th class="text-right"><?= $this->erp->formatMoney($tAmount) ?></th>
                            <th class="text-right"><?= $this->erp->formatMoney($tPaid) ?></th>
                            <th class="text-right"><?= $this->erp->formatMoney($tReturn) ?></th>
                            <th class="text-right"><?= $this->erp->formatMoney($tDeposit) ?></th>
                            <th class="text-right"><?= $this->erp->formatMoney($tDiscount) ?></th>
                            <th class="text-right"><?= $this->erp->formatMoney($tbalance) ?></th>
                            <th class="text-center"><?= lang('actions') ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0, shipping = 0,
        product_tax = 0, total = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>, toitems = {},
        audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3'),
        audio_error = new Audio('<?= $assets ?>sounds/sound3.mp3');
    $(document).ready(function () {
        <?php if ($transfer) { ?>
        __setItem('todate', '<?= date($dateFormats['php_ldate'], strtotime($transfer->date)) ?>');
        __setItem('biller_id', '<?= $using_stock->biller_id ?>');
        __setItem('from_warehouse', '<?= $transfer->from_warehouse_id ?>');
        __setItem('toref', '<?= $transfer->transfer_no ?>');
        __setItem('to_warehouse', '<?= $transfer->to_warehouse_id ?>');
        __setItem('tostatus', '<?= $transfer->status ?>');
        __setItem('tonote', '<?= str_replace(array("\r", "\n","'"), array("","","&#039"), $this->erp->decode_html($transfer->note)); ?>');
        __setItem('toshipping', '<?= $transfer->shipping ?>');
        __setItem('toitems', JSON.stringify(<?= $transfer_items; ?>));
        __setItem('authorize_id', '<?= $using_stock->authorize_id; ?>');
        __setItem('employee_id', '<?= $using_stock->employee_id; ?>');
        <?php } ?>
		
		$("#todate").datetimepicker({
			format: site.dateFormats.js_ldate,
			fontAwesome: true,
			language: 'erp',
			weekStart: 1,
			todayBtn: 1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0
		}).datetimepicker('update', new Date());
			
        $(document).on('change', '#todate', function (e) {
            __setItem('todate', $(this).val());
        });
        if (todate = __getItem('todate')) {
            $('#todate').val(todate);
        }
        if (__getItem('authorize_id')) {
            __removeItem('authorize_id');
        }
        if (__getItem('employee_id')) {
            __removeItem('employee_id');
        }
		
        ItemnTotals();
        $("#add_item").autocomplete({
            //source: '<?= site_url('transfers/suggestions'); ?>',
            source: function (request, response) {
                if (!$('#from_warehouse').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?=lang('select_above');?>');
                    //response('');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('transfers/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#from_warehouse").val()
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    if ($('#from_warehouse').val()) {
                        bootbox.alert('<?= lang('no_match_found') ?>', function () {
                            $('#add_item').focus();
                        });
                    } else {
                        bootbox.alert('<?= lang('please_select_warehouse') ?>', function () {
                            $('#add_item').focus();
                        });
                    }
                    // $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    // $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
				
                    var row = add_transfer_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
        $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });

        $(window).bind('beforeunload', function (e) {
            $.get('<?= site_url('welcome/set_data/remove_tols/1'); ?>');
            if (count > 1) {
                var message = "You will loss data!";
                return message;
            }
        });
        $('#reset').click(function (e) {
            $(window).unbind('beforeunload');
        });
        $('#edit_transfer').click(function () {
            $(window).unbind('beforeunload');
            $('form.edit-to-form').submit();
        });
        var to_warehouse;
        $('#to_warehouse').on("select2-focus", function (e) {
            to_warehouse = $(this).val();
        }).on("select2-close", function (e) {
            if ($(this).val() == $('#from_warehouse').val()) {
                $(this).select2('val', to_warehouse);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
        var from_warehouse;
        $('#from_warehouse').on("select2-focus", function (e) {
            from_warehouse = $(this).val();
        }).on("select2-close", function (e) {
            if ($(this).val() == $('#to_warehouse').val()) {
                $(this).select2('val', from_warehouse);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-edit"></i><?= lang('edit_transfer'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-to-form');
                echo form_open_multipart("transfers/edit/" . $transfer->id, $attrib)
                ?>
                <div class="row">
                    <div class="col-lg-12">

                        <?php if ($Owner || $Admin || $Settings->allow_change_date == 1) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "todate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="todate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('authorize_by', 'authorize_by'); ?>
                                <?php
                                
                                    foreach ($AllUsers as $AU) {
                                        $users[$AU->id] = $AU->username;
                                    }
                              
                                echo form_dropdown('authorize_id', $users, $using_stock->authorize_id, 'class="form-control"  required  id="authorize_id" placeholder="' . lang("select") . ' ' . lang("authorize_id") . '" style="width:100%"')
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang('employee', 'employee'); ?>
                                <?php
                                
                                    foreach ($employees as $epm) {
                                        $em[$epm->id] = $epm->fullname;
                                    }
                              
                                echo form_dropdown('employee_id', $em, $using_stock->employee_id, 'class="form-control"    id="employee_id" placeholder="' . lang("select") . ' ' . lang("employee") . '" style="width:100%"')
                                ?>                                
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("reference_no", "toref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $rnumber), 'class="form-control input-tip" id="toref" required="required" readonly'); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= get_dropdown_project('biller_id', 'biller_id', $using_stock->biller_id); ?>
                            </div>
                        </div>

                        <!--
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("status", "status") ?>
                                <?php
                        $status = array('completed' => lang('completed'), 'requested' => lang('requested'));

                        echo form_dropdown('status', $status, $using_stock->status, 'class="form-control"    id="tostatus" placeholder="' . lang("select") . ' ' . lang("status") . '" style="width:100%"')
                        ?>
                            </div>
                        </div>
                        -->
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document1" type="file" name="document1" data-show-upload="false" data-show-preview="false" class="form-control file"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-warning">
                                <div
                                    class="panel-heading"><?= lang('please_select_these_before_adding_product') ?></div>
                                <div class="panel-body" style="padding: 5px;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("from_warehouse", "from_warehouse"); ?>
                                            <?php 
											$wh[''] = '';
											foreach ($warehouses as $warehouse) {
												$wh[$warehouse->id] = $warehouse->name;
											}
											echo form_dropdown('from_warehouse', $wh, (isset($_POST['from_warehouse']) ? $_POST['from_warehouse'] : ''), 'id="from_warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("from_warehouse") . '" required="required" style="width:100%;" ');
                                            ?>
                                        </div>
                                    </div>
									<div class="col-md-4">
										<div class="form-group">
											<?= lang("to_warehouse", "to_warehouse"); ?>
											<?php
											
											echo form_dropdown('to_warehouse', $wh, (isset($_POST['to_warehouse']) ? $_POST['to_warehouse'] : $Settings->default_warehouse), 'id="to_warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("to_warehouse") . '" required="required" style="width:100%; pointer-events:none;" ');
											?>
										</div>
									</div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12" id="sticker">
                            <div class="well well-sm">
                                <div class="form-group" style="margin-bottom:0;">
                                    <div class="input-group wide-tip">
                                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                            <i class="fa fa-2x fa-barcode addIcon"></i></div>
                                        <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . $this->lang->line("add_product_to_order") . '"'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang("order_items"); ?></label>

                                <div class="controls table-controls">
                                    <table id="toTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr>
												<th class="col-md-5"><?= lang("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th>
												<?php
												if ($Settings->product_expiry) {
													echo '<th class="col-md-2">' . $this->lang->line("expiry_date") . '</th>';
												}
												?>
												<th class="col-md-2"><?= lang("QOH"); ?></th>
												<th class="col-md-2"><?= lang("quantity"); ?></th>
												<th class="col-md-3"><?= lang("unit"); ?></th>
												<th style="width: 1px !important; text-align: center;">
													<i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
												</th>
											</tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="from-group">
                                <?= lang("note", "tonote"); ?>
                                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'id="tonote" class="form-control" style="margin-top: 10px; height: 100px;"'); ?>
                            </div>
                            <div  class="from-group"><?php echo form_submit('edit_transfer', $this->lang->line("submit"), 'id="edit_transfer" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
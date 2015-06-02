<?php
/*   */
?>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('cdc.new_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('cuentadc/add_cuentadc') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('cdc.cod') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_codigo" name="txt_c_codigo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('cdc.descr') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_cuenta" name="txt_c_cuenta">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('cdc.emp') ?></label>
                <div class="controls span6">
                    <input id="cb_empresa" name="cb_empresa" class="row-fluid"/>
                </div>
            </div>
            <div class="form-actions row-fluid">
                <div class="span3 visible-desktop"></div>
                <div class="span7 ">
                    <button id="submit" class="btn btn-primary" type="submit"><?= lang('boton.register') ?></button>
                    <button id="close" class="btn btn-primary" data-dismiss="modal"><?= lang('boton.close') ?></button>
                </div>
            </div>
            <div id="msgForm"></div>
        </form>
    </div>
</div>


<script type="text/javascript">
    /**** Specific JS for this page ****/
    
    var cb_empresa;
    
    $(document).ready(function () {
        
        $.populateComboBox('#cb_empresa', "<?= lang('cdc.selec')?>", 'Empresa', 'c_codigo', <?php echo (isset($arrEmp)) ? $arrEmp : 'null' ?>, 1);
        cb_empresa = $("#cb_empresa").data("kendoComboBox");
        
        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
    });
</script>

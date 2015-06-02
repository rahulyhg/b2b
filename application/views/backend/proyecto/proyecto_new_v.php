<?php
/*   */
?>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('proy.new_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('proyecto/add_proyecto') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('proy.cod') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_codigo" name="txt_c_codigo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('proy.proy') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_proyecto" name="txt_c_proyecto">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('proy.ctaproy') ?></label>
                <div class="controls span6">
                    <input id="cb_cta_control" name="cb_cta_control" class="row-fluid" >
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('proy.ctaing') ?></label>
                <div class="controls span6">
                    <input id="cb_cta_ingreso" name="cb_cta_ingreso" class="row-fluid" >
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
    
    var cb_cta_control, cb_cta_ingreso;
    
    $(document).ready(function () {
                
        $.populateComboBox('#cb_cta_control', "<?= lang('proy.seltip')?>", 'Cuenta', 'c_codigo', <?php echo (isset($arrCtaControl)) ? $arrCtaControl : 'null' ?>, 1);    
        cb_cta_control = $("#cb_cta_control").data("kendoComboBox");
        
        $.populateComboBox('#cb_cta_ingreso', "<?= lang('proy.seltip')?>", 'Cuenta', 'c_codigo', <?php echo (isset($arrCtaIngreso)) ? $arrCtaIngreso : 'null' ?>, 1);    
        cb_cta_ingreso = $("#cb_cta_ingreso").data("kendoComboBox");
        
        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
    });
</script>

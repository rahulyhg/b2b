<?php
/*   */
?>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('emp.new_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('empresa/add_empresa') ?>" method="POST" class="form-horizontal row-fluid">
            <!-- 
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3">Codigo de Solicitud</label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_codigo" name="txt_c_codigo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3">Descripcion</label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="c_concepto" name="c_concepto">
                     </span>
                 </div>
            </div> -->
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3">Tipo Solicitud</label>
                <div class="controls span6">
                    <input id="cb_tipo_solicitud" name="cb_tipo_solicitud" class="row-fluid" >
                </div>
            </div>
            <div id="msgForm"></div>
        </form>
    </div>
</div>


<script type="text/javascript">
    /**** Specific JS for this page ****/
    $(document).ready(function () {
        $.populateComboBox('#cb_tipo_solicitud', "Seleccione tipo", 'Cuenta', 'c_codigo', <?php echo (isset($arrCtaControl)) ? $arrCtaControl : 'null' ?>, 1);    
        cb_cta_control = $("#cb_tipo_solicitud").data("kendoComboBox");
        
        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
    });
</script>

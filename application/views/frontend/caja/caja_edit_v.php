<?php
/*   */
?>

<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('caja.edit_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('caja/upd_caja') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid hide">
                <div class="controls span8 hide">
                    <input type="text" class="hide" id="txt_id" name="txt_id" value="<?php if (isset($txt_id)) echo $txt_id ?>">
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('caja.cod') ?></label>
                <div class="controls span8">
                    <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_codigo" name="txt_c_codigo" value="<?php if (isset($txt_c_codigo)) echo $txt_c_codigo ?>" disabled>
                    </span>
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('caja.descr') ?></label>
                <div class="controls span8">
                    <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_caja" name="txt_c_caja" value="<?php if (isset($txt_c_caja)) echo $txt_c_caja ?>">
                    </span>
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('caja.mon') ?></label>
                <div class="controls span6">
                    <input id="cb_moneda" name="cb_moneda" class="row-fluid" value="<?php if (isset($cb_moneda)) echo $cb_moneda ?>" >
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('caja.emp') ?></label>
                <div class="controls span6">
                    <input id="cb_empresa" name="cb_empresa" class="row-fluid" value="<?php if (isset($cb_empresa)) echo $cb_empresa ?>" />
                </div>
            </div>
               <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('caja.tipo') ?></label>
                <div class="controls span6">
                    <input id="cb_tipo" name="cb_tipo" class="row-fluid" value="<?php if (isset($cb_tipo)) echo $cb_tipo ?>" />
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('caja.estado') ?></label>
                <div class="controls span4">
                    <input id="cb_estado" name="cb_estado" class="row-fluid" value="<?php if (isset($cb_estado)) echo $cb_estado ?>"/>
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
    
    var cb_moneda, cb_empresa, cb_estado;
    
    $(document).ready(function () {
        
        $.populateComboBox('#cb_moneda', '', 'c_moneda', 'id_moneda', <?php echo (isset($arrMoneda)) ? $arrMoneda : 'null' ?>, 1);//, arr_TipEmp);       
        cb_moneda = $("#cb_moneda").data("kendoComboBox");
        
        $.populateComboBox('#cb_empresa', '', 'Empresa', 'c_codigo', <?php echo (isset($arrEmpresa)) ? $arrEmpresa : 'null' ?>, 1);
        cb_empresa = $("#cb_empresa").data("kendoComboBox");
        
        $.populateComboBox('#cb_tipo', '', 'Tipo', 'id_tipo', <?php echo (isset($arrTipo)) ? $arrTipo : 'null' ?>, 1);
        cb_tipo = $("#cb_tipo").data("kendoComboBox");
        
        //$.populateComboBox('#cb_cuenta', Seleccione2, 'c_cuenta', 'c_codigo', <//?php echo (isset($arrCuentas)) ? $arrCuentas : 'null' ?>, 1);//, arr_TipEmp);       
        //cb_cuenta = $("#cb_cuenta").data("kendoComboBox");
        
        $.populateComboBox('#cb_estado', '', 'c_tipo', 'id_tipo', <?php echo (isset($arrEst)) ? $arrEst : 'null' ?>, 1);
        cb_estado = $("#cb_estado").data("kendoComboBox");
        
        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");

    });
</script>

<?php
/*   */
?>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('subproy.new_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('subproyecto/add_subproyecto') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('subproy.cod') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_scodigo" name="txt_c_scodigo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('subproy.descr') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_sproyecto" name="txt_c_sproyecto">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('subproy.proy') ?></label>
                <div class="controls span6">
                    <input id="cb_proyecto" name="cb_proyecto" class="row-fluid" >
                </div>
            </div>
            <!--<div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><//?= lang('subproy.cuen') ?></label>
                <div class="controls span6">
                    <input id="cb_cuenta" name="cb_cuenta" class="row-fluid" >
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><//?= lang('subproy.tipo') ?></label>
                <div class="controls span6">
                    <input id="cb_tipocuenta" name="cb_tipocuenta" class="row-fluid" />
                </div>
            </div>-->
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

    var cb_proyecto, cb_cuenta, cb_tipocuenta;
    
    $(document).ready(function () {

        $.populateComboBox('#cb_proyecto', "<?= lang('subproy.selproy')?>", 'Proyecto', 'id_proyecto', <?php echo (isset($arrProyectos)) ? $arrProyectos : 'null' ?>, 1);//, arr_TipEmp);       
        cb_proyecto = $("#cb_proyecto").data("kendoComboBox");
        /*
        $.populateComboBox('#cb_cuenta', "<//?= lang('subproy.selcuen')?>", 'c_cuenta', 'c_codigo', <//?php echo (isset($arrCuentas)) ? $arrCuentas : 'null' ?>, 1);//, arr_TipEmp);       
        cb_cuenta = $("#cb_cuenta").data("kendoComboBox");

        $.populateComboBox('#cb_tipocuenta', "<//?= lang('subproy.seltipo')?>", 'c_tipo', 'id_tipo', <//?php echo (isset($arrTipoCuenta)) ? $arrTipoCuenta : 'null' ?>, 1);
        cb_tipocuenta = $("#cb_tipocuenta").data("kendoComboBox");
        */
        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
    });
</script>
<?php
/*   */
?>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('tipo.new_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('tipo/add_tipo') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('tipo.id') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_id_tipo" name="txt_id_tipo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('tipo.desc') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_tipo" name="txt_c_tipo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('tipo.padre') ?></label>
                <div class="controls span6">
                    <input id="cb_id_tipo_padre" name="cb_id_tipo_padre" class="row-fluid" >
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
                
        $.populateComboBox('#cb_id_tipo_padre', "<?= lang('tipo.selpa')?>", 'Padre', 'id_tipo', <?php echo (isset($arrPadre)) ? $arrPadre : 'null' ?>, 1);    
        cb_id_tipo_padre = $("#cb_id_tipo_padre").data("kendoComboBox");
        

        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
    });
</script>

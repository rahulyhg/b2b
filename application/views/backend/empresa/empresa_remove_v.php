<?php
/*   */
?>

<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('emp.delete_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('empresa/dlt_empresa') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid hide">
                <div class="controls span8 hide">
                    <input type="text" class="hide" id="txt_id" name="txt_id" value="<?php if (isset($txt_id)) echo $txt_id ?>">
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('emp.cod') ?></label>
                <div class="controls span8">
                    <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_codigo" name="txt_c_codigo" value="<?php if (isset($txt_c_codigo)) echo $txt_c_codigo ?>" disabled>
                    </span>
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('emp.descr') ?></label>
                <div class="controls span8">
                    <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_nomraz" name="txt_c_nomraz" value="<?php if (isset($txt_c_nomraz)) echo $txt_c_nomraz ?>" disabled>
                    </span>
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('emp.estado') ?></label>
                <div class="controls span4">
                    <input id="cb_estado" name="cb_estado" class="row-fluid" value="<?php if (isset($cb_estado)) echo $cb_estado ?>" disabled/>
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
    
    var cb_estado;
                        
    $(document).ready(function () {
        
        $.populateComboBox('#cb_estado', '', 'c_tipo', 'id_tipo', <?php echo (isset($arrEst)) ? $arrEst : 'null' ?>, 1);
        cb_estado = $("#cb_estado").data("kendoComboBox");
        
        $.saveModal('#frmNew', 'button#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");

    });
</script>

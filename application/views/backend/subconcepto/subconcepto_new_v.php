<?php
/*   */
?>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('sconcep.new_title') ?></span> 
        </h4>
    </div>
    <div class="content">
        <form id="frmNew" action="<?= site_url('subconcepto/add_subconcepto') ?>" method="POST" class="form-horizontal row-fluid">
            
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('sconcep.cod') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_scodigo" name="txt_c_scodigo">
                     </span>
                 </div>
            </div>
            <div class="form-row control-group row-fluid">
                 <label for="normal-field" class="control-label span3"><?= lang('sconcep.descr') ?></label>
                 <div class="controls span8">
                     <span class="row-fluid k-textbox">
                        <input type="text" class="row-fluid" id="txt_c_sconcepto" name="txt_c_sconcepto">
                     </span>
                 </div>
            </div>
            
          <div class="form-row control-group row-fluid">
                <label for="normal-field" class="control-label span3"><?= lang('sconcep.concep') ?></label>
                <div class="controls span6">
                    <input id="cb_id_concepto" name="cb_id_concepto" class="row-fluid" >
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
        
    var c_id_concepto;
    
    $(document).ready(function () {
        
         
         
        $.populateComboBox('#cb_id_concepto', "<?= lang('sconcep.selcon')?>", 'Concepto', 'id_concepto', <?php echo (isset($arrConceptos)) ? $arrConceptos : 'null' ?>, 1);//, arr_TipEmp);       
        cb_id_concepto = $("#cb_id_concepto").data("kendoComboBox");   
        
        $.saveModal('#frmNew', '#submit', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
    });
</script>

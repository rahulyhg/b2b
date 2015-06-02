<?php
/*    */
?>

<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?= lang('cproy.conf_title') ?></span>
        </h4>
    </div>
    <div class="content cursor">
        <form id="frmNew" action="<?= site_url('conceptoxproyecto/upd_conceptos_activos') ?>" method="POST" class="form-horizontal row-fluid">
            <div class="form-row control-group row-fluid hide">
                <div class="controls span8 hide">
                    <input type="text" class="hide" id="txt_id" name="txt_id" value="<?php if (isset($txt_id)) echo $txt_id ?>">
                </div>
            </div>
            <div class="form-row control-group row-fluid">
                <label for="hint-field" class="control-label span3"><?= lang('cproy.proy') ?></label>
                <div class="controls span8">
                    <input type="text" disabled="disabled" class="row-fluid" id="txt_c_proyecto" name="txt_c_proyecto" value="<?php if (isset($txt_c_proyecto)) echo $txt_c_proyecto ?>">
                </div>
            </div>
            <div class="form-row control-group row-fluid span2">
            </div>
            <div class="form-row control-group row-fluid ">
                <table style="width: 70%" >    
                    <tr>
                        <td style="width: 100%"><?= lang('cproy.conc') ?></td>
                    </tr>
                    <tr>
                        <td style="width: 50%">
                            <div class="tab-content" style="height: 250px">
                                <?php
                                    $valDefault = '';
                                    $Todos = lang('g.todos');
                                    if (isset($chklist_concepto))
                                        $valDefault = $chklist_concepto;
                                    echo form_checklist('chklist_concepto', $arrConcepto, $valDefault, lang('g.todos'));
                                ?>
                            </div>
                       </td>
                    </tr>
                </table>
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
    $(document).ready(function () {
        var Error = "<?= lang('error.ines')?>";
        //prevent event formulario
        $('#frmNew').submit(function(event) {  
            event.preventDefault();  
            var url = $(this).attr('action');  
            var datos = $(this).serialize();  
            $.ajax({
                type: "POST",
                dataType: "html",
                url: url,
                data: datos,
                success: function(resultado){
                    if (resultado == ''){                    
                        $('#list1').trigger( 'reloadGrid' );
                        $('#close').trigger('click');
                    }
                    $('#msgForm').html(resultado);
                },
                error: function(){
                    $('#msgForm').html(Error);
                }
            });
        });
         
	//Checkbox concepto
	$("input[name=chklist_concepto_todos]").change(function(){
		$('input[name=chklist_concepto\\[\\]]').each( function() {
			if($("input[name=chklist_concepto_todos]:checked").length == 1){
				this.checked = true;
			} else {
				this.checked = false;
			}
		});
	});
        $("input[name=chklist_concepto\\[\\]]").change(function(){
                var $ok = 1;
                $('input[name=chklist_concepto\\[\\]]').each( function() {
			if(!this.checked){
                            $ok = 0;
                        } 
		});
                if($ok == 1)
                {
                    $("input[name=chklist_concepto_todos]").attr("checked", "checked");
                }else
                {
                    $("input[name=chklist_concepto_todos]").removeAttr("checked");
                }
	});
        
    });
</script>

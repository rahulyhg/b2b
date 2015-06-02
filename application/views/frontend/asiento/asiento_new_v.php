<?php
/*   */

?>


<div id="main_container">
    <div class="row-fluid">
        <div>
            <label for="normal-field" style="font-size: 30px" class="control-label span6"><?= lang('asiento.new_title') ?></label>
        </div>
        <br/>
        <br>
        <br>
        <br/>
        <label for="normal-field" class="control-label span2"><?= lang('asiento.desc') ?></label>
        <div class="controls span3">
            <span class="row-fluid k-textbox">
                <input  id="txt_descripcion" name="txt_descripcion" value="" />
            </span>
        </div>
        <br/>
        <br>
        <br/>
        <br>
        <div class="row-fluid" >
            <a id="btnBack" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.back') ?></a>
            <a id="btnSave" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.save') ?></a>
        </div>
        <div id="dlgNew" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <!-- Div donde cargarán los fomularios -->
        </div>
        <br/>
        <br>
        <!--<div id="tbData">
            
        </div>-->
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        
        var TituloInformacion = "<?= lang('g.titleMsgInfo')?>";
        //var Seleccione = "<?= lang('caja.selec')?>";
        // boton Volver
        $('#btnBack').on('click', (function() {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "asiento/back_asiento/",// + selr,
                //data: {id : selr, name : rd},
                beforeSend: function(){
                   $("#btnNew").attr("disabled", "disabled");
                   $("#btnNew").html("<?= lang('g.msgProcesing')?>");
                },
                success: function(resultado){
                    if (resultado){
                        $('#main_container').html(resultado);
                    } else {
                            jAlert ('El registro no existe',TituloInformacion);
                        }
                    },
                error: function(){
                    jAlert('Error al cargar el registro',TituloInformacion);
                    $("#btnNew").removeAttr("disabled");
                    $("#btnNew").html("<?=lang('boton.new')?>");
                },
                complete: function(){
                    $("#btnNew").removeAttr("disabled");
                    $("#btnNew").html("<?=lang('boton.new')?>");
                }
            });
        }));
        
        // boton modificar
        $('#btnSave').on('click', (function() {
            
            if($(txt_descripcion).val() == ''){
                return jAlert('<?= lang('asiento.alert')?>',TituloInformacion);
            }else{
                var URL= "asiento/add_asiento/";
                if( $("#txt_descripcion").val() == ""){
                    URL = URL + "-1" + "/";
                }else{
                    URL = URL + $("#txt_descripcion").val() + "/";
                }
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url:URL,
                    beforeSend: function(){
                       $("#btnSave").attr("disabled", "disabled");
                       $("#btnSave").html("<?= lang('g.msgProcesing')?>");
                    },
                    success: function(resultado){
                        console.log(resultado);
                        if (resultado == 'Ya existe un registro con esa descripción.'){
                            //$('#loadgrid').html(resultado);
                            jAlert (resultado, TituloInformacion);
                        } else {
                            //jAlert ('saltar de pagina', TituloInformacion);
                            //--------------------------------------------
                            $('#main_container').html(resultado);
                            //--------------------------------------------
                        }
                    },
                    error: function(){
                        jAlert('<?= lang('rptcaja.exist')?>', TituloInformacion);
                    },
                    complete: function(){
                        $("#btnSave").removeAttr("disabled");
                        $("#btnSave").html("<?= lang('boton.save') ?>");
                    }
                 });
            }
            
        }));
        
    });
</script>

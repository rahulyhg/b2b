    
<?php
$i = 1;

?>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<div id="main_container">
    <div class="row-fluid">
        
        
        <div class="row-fluid" >
            <a id="btnIndicadores" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.indicadores') ?></a>

        </div>
    </div>
</div>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var tituloInformacion = "<?= lang('g.titleMsgInfo')?>";
        $('#btnIndicadores').on('click', (function() {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "main/load_indicadores/",// + selr,
                //data: {id : selr, name : rd},
                beforeSend: function(){
                   $("#btnIndicadores").attr("disabled", "disabled");
                   $("#btnIndicadores").html("<?= lang('g.msgProcesing')?>");
                },
                success: function(resultado){
                    if (resultado){
                        $('#main_container').html(resultado);
                    } else {
                            jAlert ('El registro no existe',tituloInformacion);
                        }
                    },
                error: function(){
                    jAlert('Error al cargar el registro',tituloInformacion);
                    $("#btnIndicadores").removeAttr("disabled");
                    $("#btnIndicadores").html("<?=lang('boton.indicadores')?>");
                },
                complete: function(){
                    $("#btnIndicadores").removeAttr("disabled");
                    $("#btnIndicadores").html("<?=lang('boton.indicadores')?>");
                }
            });
        }));
    })
</script>






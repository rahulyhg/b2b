<?php
/*   */

?>


<div id="main_container">
    <div class="row-fluid">
        <a id="btnNew" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.new') ?></a>
        <a id="btnEdit" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.mod') ?></a>
        <!--<a id="btnDelete" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.del') ?></a>-->

        <div id="dlgNew" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <!-- Div donde cargarán los fomularios -->
        </div>
        <br/>
        <br>
        <div id="tbData">
            
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        
        var TituloInformacion = "<?= lang('g.titleMsgInfo')?>";
        var Seleccione = "<?= lang('caja.selec')?>";
        // boton Nuevo
        $('#btnNew').on('click', (function() {
            //var param = null;
            //$.openModal('#btnNew', 'caja/new_caja', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "asiento/new_asiento/",// + selr,
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
        $('#btnEdit').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_agrupado;
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "asiento/edit_asiento/" + id,
                    //data: {id : selr, name : rd},
                    beforeSend: function(){
                       $("#btnEdit").attr("disabled", "disabled");
                       $("#btnEdit").html("<?= lang('g.msgProcesing')?>");
                    },
                    success: function(resultado){
                        //console.log(resultado);
                        if (resultado){
                            $('#main_container').html(resultado);
                        } else {
                                jAlert ('El registro no existe',tituloInformacion);
                            }
                        },
                    error: function(){
                        jAlert('Error al cargar el registro',tituloInformacion);
                        $("#btnEdit").removeAttr("disabled");
                        $("#btnEdit").html("<?=lang('boton.mod')?>");
                    },
                    complete: function(){
                        $("#btnEdit").removeAttr("disabled");
                        $("#btnEdit").html("<?=lang('boton.mod')?>");
                    }
                });
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Caja');
            }
        }));
        /*
        // boton eliminar
        $('#btnDelete').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_agrupado;
                var param = {id : id};
                $.openModal('#btnDelete', 'caja/remove_caja', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Caja');
            }
        }));
        */
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('asiento/get_asiento_list') ?>",
                        success: function (resultado){
                            options.success(resultado);
                        }
                    });
                }
            },
            error: function(e) {
                alert('<?= lang('error.trans') ?>');
            },
            pageSize: 10,
            schema: {
                model: {
                    id: "id_agrupado",
                    fields: {
                        id_agrupado:      { type: "number" },
                        descripcion:        { type: "string" }
                    }
                }
            }
        });
        
        $("#tbData").kendoGrid({
            dataSource: dataSource,
            selectable: "row",
            sortable: true,
            filterable: true,
            pageable: {
                refresh: true,
                pageSize: true
            },
            columns: [ 
                { field: "id_agrupado", width: 80, title: "ID" },
                { field: "descripcion", title: "Descripción" }
            ]
        });
    });
</script>

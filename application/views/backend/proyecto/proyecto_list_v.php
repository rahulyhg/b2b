<?php
/*   */

?>


<div id="main_container">
    <div class="row-fluid">
        <a id="btnNew" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.new') ?></a>
        <a id="btnEdit" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.mod') ?></a>
        <a id="btnConfig" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.conf') ?></a>
        <a id="btnDelete" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.del') ?></a>
        
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
        var Seleccione = "<?= lang('proy.selec')?>";
        // boton Nuevo
        $('#btnNew').on('click', (function() {
            var param = null;
            $.openModal('#btnNew', 'proyecto/new_proyecto', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
        }));
        
        // boton modificar
        $('#btnEdit').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_proyecto;
                var param = {id : id};                
                $.openModal('#btnEdit', 'proyecto/edit_proyecto', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Caja');
            }
        }));
        
        $('#btnConfig').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_proyecto;
                var param = {id : id};
                $.openModal('#btnConfig', 'proyecto/configurar', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Caja');
            }
        }));
        
        // boton eliminar
        $('#btnDelete').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_proyecto;
                var param = {id : id};
                $.openModal('#btnDelete', 'proyecto/remove_proyecto', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Caja');
            }
        }));
        
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('proyecto/get_proyecto_list') ?>",
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
                    id: "id_proyecto",
                    fields: {
                        id_proyecto:      { type: "number" },
                        c_codigo:        { type: "string" },
                        c_proyecto:        { type: "string" },
                        cta_control:        { type: "string" },
                        cta_ingreso:        { type: "string" },
                        Estado:          { type: "string" }
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
                { field: "c_codigo", width: 80, title: "Codigo" },
                { field: "c_proyecto", title: "Centro de Asignación" },
                { field: "cta_control", width: 170, title: "Cuenta 1" },
                { field: "cta_ingreso", width: 170, title: "Cuenta 2" },
                { field: "Estado", width: 75, title: "<?= lang('empl.act') ?>" }
            ]
        });
    });
</script> 

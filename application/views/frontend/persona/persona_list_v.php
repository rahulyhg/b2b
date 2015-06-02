<?php
/*   */

?>


<div id="main_container">
    <div class="row-fluid">
        <a id="btnNew" href="#" class="btn btn-secondary color_14" data-toggle="modal">Nuevo</a>
        <!--<a id="btnEdit" href="#" class="btn btn-secondary color_14"  data-toggle="modal">Modificar</a>-->
        <!--<a id="btnDelete" href="#" class="btn btn-secondary color_14"  data-toggle="modal">Eliminar</a>-->

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
//        $('#btnNew').on('click', (function() {
//            var param = null;
//            $.openModal('#btnNew', 'caja/new_caja', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
//        }));
//        
//        // boton modificar
//        $('#btnEdit').on('click', (function() {
//            var grid = $("#tbData").data("kendoGrid");
//            var row = grid.select();
//            if ( grid.dataItem(grid.select()) != undefined){
//                var id = grid.dataItem(grid.select()).id_caja;
//                var param = {id : id};                
//                $.openModal('#btnEdit', 'caja/edit_caja', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
//            } else{
//                jAlert('No valido', 'Caja');
//            }
//        }));
//        
//        // boton eliminar
//        $('#btnDelete').on('click', (function() {
//            var grid = $("#tbData").data("kendoGrid");
//            var row = grid.select();
//            if ( grid.dataItem(grid.select()) != undefined){
//                var id = grid.dataItem(grid.select()).id_caja;
//                var param = {id : id};
//                $.openModal('#btnDelete', 'caja/remove_caja', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
//            } else{
//                jAlert('No valido', 'Caja');
//            }
//        }));
        
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('persona/get_persona_list') ?>",
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
                    id: "id_persona",
                    fields: {
                        id_proveedor:      { type: "number" },
                        nombre_completo:        { type: "string" },
                        documento_identidad:        { type: "string" },
                        telefono:         { type: "string"}
                        // Moneda:     { type: "string" },
                        // id_empresa:     { type: "string" },
                        //Cuenta:     { type: "string" },
                        // Estado:          { type: "string" }
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
                { field: "nombre_completo", title: "Nombre" },
                { field: "documento_identidad", title: "Nro Documento" },
                { field: "telefono", title: "Tlfno." }
                // { field: "Moneda", title: "Moneda" },
                // { field: "id_empresa", title: "Empresa" },
                //{ field: "Cuenta", title: "Cuenta" },
                // { field: "Estado", width: 75, title: "Activo" }
            ]
        });
    });
</script>

<?php
/*   */

?>


<div id="main_container">
    <div class="row-fluid">
        <a id="btnNew" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.new') ?></a>
        <a id="btnEdit" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.mod') ?></a>
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
        var Seleccione = "<?= lang('sconcep.selec')?>";
        // boton Nuevo
        $('#btnNew').on('click', (function() {
            var param = null;
            $.openModal('#btnNew', 'subconcepto/new_subconcepto', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
        }));
        
        // boton modificar
        $('#btnEdit').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_sconcepto;
                var param = {id : id};                
                $.openModal('#btnEdit', 'subconcepto/edit_subconcepto', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Caja');
            }
        }));
        
        // boton eliminar
        $('#btnDelete').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_sconcepto;
                var param = {id : id};
                $.openModal('#btnDelete', 'subconcepto/remove_subconcepto', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
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
                        url: "<?= site_url('subconcepto/get_subconcepto_list') ?>",
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
                    id: "id_sconcepto",
                    fields: {
                        id_sconcepto:        { type: "number" },
                        c_sconcepto:        {type: "string"},
                        c_scodigo:            { type: "string" },
                        c_concepto:          { type: "string" },                        
                        Estado:              { type: "string" }
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
                { field: "c_scodigo", width: 80, title: "Codigo" },
                { field: "c_sconcepto", title: "Sub Concepto" },
                { field: "c_concepto", title: "Concepto"},
                { field: "Estado", width: 75, title: "<?= lang('empl.act') ?>" }
            ]
        });
    });
</script> 
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

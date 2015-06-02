<?php
/*   */

?>


<div id="main_container">
    <div class="row-fluid">
        <div class="form-row control-group row-fluid hide">
                <div class="controls span8 hide">
                    <input type="text" class="hide" id="txt_id" name="txt_id" value="<?php if (isset($txt_id)) echo $txt_id ?>">
                </div>
        </div>
        <div>
            <label for="normal-field" style="font-size: 30px" class="control-label span6"><?= lang('asiento.edit_title') ?></label>
        </div>
        
        <br>
        <br/>
        <label for="normal-field" class="control-label span2"><?= lang('asiento.desc') ?></label>
        <div class="controls span3">
            <span class="row-fluid k-textbox">
                <input  id="txt_descripcion" name="txt_descripcion" value="<?php if (isset($txt_descripcion)) echo $txt_descripcion ?>" />
            </span>
        </div>
        <br/>
        <br>
        
        <div id="tbData2">
            
        </div>
        <!--
        <label for="normal-field" class="control-label span2"><?= lang('asiento.ingreso') ?></label>
        <div class="controls span3">
            <span class="row-fluid k-textbox">
                <input  id="txt_ingreso" name="txt_ingreso" value="<?php if (isset($txt_ingreso)) echo $txt_ingreso ?>" />
            </span>
        </div>
        <br/>
        <br> 
        <label for="normal-field" class="control-label span2"><?= lang('asiento.egreso') ?></label>
        <div class="controls span3">
            <span class="row-fluid k-textbox">
                <input  id="txt_egreso" name="txt_egreso" value="<?php if (isset($txt_egreso)) echo $txt_egreso ?>" />
            </span>
        </div>
        -->
        <br/>
        <br> 
        <div class="row-fluid" >
            <a id="btnBack" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.back') ?></a>
            <!--<a id="btnSave" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.save') ?></a>-->
            <a id="btnTran" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.tran') ?></a>
        </div>
        <br/>
        <br>
        <!--<div class="row-fluid" >-->
            <a id="btnNew" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.new') ?></a>
            <a id="btnEdit" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.mod') ?></a>
            <a id="btnDelete" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.del') ?></a>
            <!--
            <a id="btnExportar" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.export')?></a>
            <a id="btnImprimir" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.print')?></a>
            -->
        <!--</div>-->
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
                            jAlert ('El registro no existe',tituloInformacion);
                        }
                    },
                error: function(){
                    jAlert('Error al cargar el registro',tituloInformacion);
                    $("#btnNew").removeAttr("disabled");
                    $("#btnNew").html("<?=lang('boton.new')?>");
                },
                complete: function(){
                    $("#btnNew").removeAttr("disabled");
                    $("#btnNew").html("<?=lang('boton.new')?>");
                }
            });
        }));
        
        // boton Transferir a transacciones
        $('#btnTran').on('click', (function() {
            var TituloInformacion = "<?= lang('g.titleMsgInfo')?>";
            var URL= "asiento/transfer_asiento/";
            $.ajax({
                 type: "POST",
                 dataType: "html",
                 url:URL,
                 beforeSend: function(){
                    $("#btnTran").attr("disabled", "disabled");
                    $("#btnTran").html("<?= lang('g.msgProcesing')?>");
                 },
                 success: function(resultado){
                     console.log(resultado);
                     if (resultado == 'No debe haber diferencia , no puede transferir.' || resultado == 'No se encontraron movimientos para transferir.'){
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
                     $("#btnTran").removeAttr("disabled");
                     $("#btnTran").html("<?= lang('boton.tran') ?>");
                 }
            });
        }));
        
        // boton Nuevo
        $('#btnNew').on('click', (function() {
            var param = null;
            $.openModal('#btnNew', 'asiento/new_transaccion', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
        }));
        // boton modificar
        $('#btnEdit').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_transaccion;
                var param = {id : id};
                $.openModal('#btnDetail', 'asiento/edit_transaccion', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Transacción');
            }
        }));
        
        // boton eliminar
        $('#btnDelete').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_transaccion;
                var param = {id : id};
                $.openModal('#btnDelete', 'asiento/remove_transaccion', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Transacción');
            }
        }));
        
        //$.saveModal('#frmNew', '#btnSearch', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        var dataSource2 = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    var URL= "asiento/get_asiento_data/";
                    URL = URL + $("#txt_id").val() + "/";
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: URL, // "<?= site_url('asiento/get_transaccion_list') ?>",
                        
                        beforeSend: function(){
                            $("#btnSearch").attr("disabled", "disabled");
                            $("#btnSearch").html("<?= lang('g.msgProcesing')?>");
                         },
                        success: function (resultado){
                            options.success(resultado);
                        },
                        error: function(){
                            jAlert('<?= lang('transac.exist2')?>', TituloInformacion);
                        },
                        complete: function(){
                          $("#btnSearch").removeAttr("disabled");
                          $("#btnSearch").html("<?= lang('boton.view') ?>");
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
                    id: "id_transaccion",
                    fields: {
                        TITULO:      { type: "string" },
                        SUMA:        { type: "string" }
                    }
                }
            }
        });
        
        $("#tbData2").kendoGrid({
            dataSource: dataSource2,
            selectable: "row",
            sortable: true,
            filterable: true,
            pageable: {
                refresh: true,
                pageSize: true
            },
            columns: [ 
                { field: "TITULO", width: 50, title: "Tipo" },
                { field: "SUMA", width: 50, title: "Suma" }
            ]
        });
        
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    var URL= "asiento/get_transaccion_list/";
                    URL = URL + $("#txt_id").val() + "/";
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: URL, // "<?= site_url('asiento/get_transaccion_list') ?>",
                        
                        beforeSend: function(){
                            $("#btnSearch").attr("disabled", "disabled");
                            $("#btnSearch").html("<?= lang('g.msgProcesing')?>");
                         },
                        success: function (resultado){
                            options.success(resultado);
                            $('#tbData2').data("kendoGrid").dataSource.read();
                        },
                        error: function(){
                            jAlert('<?= lang('transac.exist2')?>', TituloInformacion);
                        },
                        complete: function(){
                          $("#btnSearch").removeAttr("disabled");
                          $("#btnSearch").html("<?= lang('boton.view') ?>");
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
                    id: "id_transaccion",
                    fields: {
                        id_transaccion:      { type: "number" },
                        Tipo_transaccion:        { type: "string" },
                        fecha_registro:     { type: "string" },
                        Caja:        { type: "string" },
                        Proyecto:     { type: "string" },
                        Concepto:     { type: "string" },
                        fecha_sistema:          { type: "string" },
                        importe:     { type: "number" },
                        importedol:     { type: "number" }
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
                { field: "Tipo_transaccion", width: 70, title: "Tipo" },
                { field: "fecha_registro", width: 130, title: "Fecha Documento" },
                { field: "Caja", width: 210, title: "Caja" },
                { field: "Proyecto", width: 190, title: "C.Asignación" },
                { field: "Concepto", width: 190, title: "Concepto" },
                { field: "fecha_sistema", width: 130, title:"Fecha Sistema" },
                { field: "importe", width: 100, title: "Importe S/." },
                { field: "importedol", width: 100, title: "Importe $" }
            ]
        });
    });
</script>

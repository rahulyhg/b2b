<?php
/*   */

?>
<style>

span.k-timepicker, span.k-datetimepicker, span.k-datepicker {
    width: auto;
}
</style>

<div id="main_container">
    <div class="row-fluid">
        <!--<a id="btnNew" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.new') ?></a>
        <a id="btnEdit" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.mod') ?></a>
        <a id="btnDelete" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.del') ?></a>
        
        <div id="dlgNew" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
        <br/>
        <br>
        -->
        <div class="row-fluid" >
            <div class="form-row control-group row-fluid ">    
                <label for="normal-field" class="control-label span1"><?= lang('rptcaja.caja') ?></label>
                <div class="controls span3">
                    <input id="cb_caja" name="cb_caja" class="row-fluid" />                   
                </div>
                <label for="normal-field" class="control-label span1"><?= lang('rptcaja.fch_ini') ?></label>
                <div class="controls span2">
                    <input  id="txt_fec_ini" name="txt_fec_ini" value="" />
                </div>
                <label for="normal-field" class="control-label span1"><?= lang('rptcaja.fch_fin') ?></label>
                <div class="controls span2">
                    <input  id="txt_fec_fin" name="txt_fec_fin" value="" />
                </div>
                <div class ="span1">
                    <a id="btnSearch" href="#" class="btn btn-secondary color_14"  data-toggle="modal"><?= lang('boton.ser') ?></a>
                </div>
            </div>
        </div>
        <div id="tbData">
            
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        
        /*
        
        var TituloInformacion = "<?= lang('g.titleMsgInfo')?>";
        var Seleccione = "<?= lang('caja.selec')?>";
        
        
        // boton Nuevo
        $('#btnNew').on('click', (function() {
            var param = null;
            $.openModal('#btnNew', 'transaccion/new_transaccion', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
        }));
        // boton modificar
        $('#btnEdit').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_transaccion;
                var param = {id : id};                
                $.openModal('#btnDetail', 'transaccion/edit_transaccion', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
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
                $.openModal('#btnDelete', 'transaccion/remove_transaccion', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Transacción');
            }
        }));
        */
        
        // boton filtrar
        
        
        $('#txt_fec_ini').bind($.browser.msie ? 'click' : 'change', function(event) {
            setFiltros();
        })
        $('#txt_fec_fin').bind($.browser.msie ? 'click' : 'change', function(event) {
            setFiltros();
        })
        
        function setFiltros(){
             
             var URL= "reportecaja/update_filtros/";
             if( $("#txt_fec_ini").val() == "")
                 URL = URL + "-1" + "/";
             else
                 URL = URL + $("#txt_fec_ini").val() + "/";
             if( $("#txt_fec_fin").val() == "")
                 URL = URL + "-1" + "/";
             else
                 URL = URL + $("#txt_fec_fin").val() + "/";   
             if( $("#cb_caja").val() == "")
                 URL = URL + "-1" + "/";
             else
                 URL = URL + $("#cb_caja").val() + "/"; 
             $.ajax({
                 type: "POST",
                 dataType: "html",
                 url:URL,
                 /*
                 beforeSend: function(){
                    $("#btnVer").attr("disabled", "disabled");
                    $("#btnVer").html("<?= lang('g.msgProcesing')?>");
                 },
                */
                 success: function(resultado){
                     console.log(resultado);
                     /*
                     if (resultado){
                         $('#loadgrid').html(resultado);
                     } else {
                         jAlert ('<?= lang('rptmov.exist1')?>', tituloInformacion);
                     }
                     */
                 },
                 error: function(){
                     jAlert('<?= lang('rptcaja.exist')?>', tituloInformacion);
                 }
                 /*
                 ,
                 complete: function(){
                    $("#btnVer").removeAttr("disabled");
                    $("#btnVer").html("<?= lang('boton.view') ?>");
                 }
                 */
              });
        }
        
        $('#btnSearch').on('click', (function() {
            $('#tbData').data("kendoGrid").dataSource.read();
            //$('#tbData').data("kendoGrid").dataSource.element.val("");
            //$('#tbData').data("kendoGrid").dataSource.selectedIndex = 1;
            $('#tbData').data("kendoGrid").dataSource.page(1);
        }));
        
        function startChange() {
            var startDate = dpFechaI.value();

            if (startDate) {
                startDate = new Date(startDate);
                startDate.setDate(startDate.getDate() + 1);
                dpFechaF.min(startDate);
            }
        }
        function endChange() {
            var endDate = dpFechaF.value();

            if (endDate) {
                endDate = new Date(endDate);
                endDate.setDate(endDate.getDate() - 1);
                dpFechaI.max(endDate);
             }
         }
         // Datepicker
         var dpFechaI = $("#txt_fec_ini").kendoDatePicker({
               change: startChange,
               format: "yyyy-MM-dd"
         }).data("kendoDatePicker"); 

         // Datepicker
         var dpFechaF = $("#txt_fec_fin").kendoDatePicker({
               change: endChange,
               format: "yyyy-MM-dd"
         }).data("kendoDatePicker");
         
         dpFechaI.max(dpFechaF.value());
         dpFechaF.min(dpFechaI.value());
       
        $.saveModal('#frmNew', '#btnSearch', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
        $.populateComboBox('#cb_caja', "", 'Caja', 'c_codigo', <?php echo (isset($arrCaja)) ? $arrCaja : 'null' ?>, 1);
        
        $('#cb_caja').bind($.browser.msie ? 'click' : 'change', function(event) {
            setFiltros();
        })
        
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('reportecaja/get_saldos_list') ?>",
                        beforeSend: function(){
                            $("#btnSearch").attr("disabled", "disabled");
                            $("#btnSearch").html("<?= lang('g.msgProcesing')?>");
                         },
                        success: function (resultado){
                            options.success(resultado);
                        },
                        error: function(){
                            jAlert('<?= lang('rptcaja.exist')?>', tituloInformacion);
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
                    id: "c_codigo",
                    fields: {
                        c_codigo:      { type: "number" },
                        c_caja:        { type: "string" },
                        SaldoDol:     { type: "number" },
                        SaldoSol:     { type: "number" }
                        //fecha_registro:     { type: "string" },
                        //fecha_sistema:          { type: "string" }
                    }
                }
            },
            aggregate: [{ field: "SaldoDol",  aggregate: "sum" },
                         { field: "SaldoSol", aggregate: "sum" }]
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
                { field: "c_codigo", width: 70, title: "Caja" },
                { field: "c_caja", width: 200, title: "Caja"},
                { field: "SaldoDol", width: 80, attributes:{style:"text-align:right;"}, title: "Saldo $", footerTemplate: "<div style='float: right'>Total: #=kendo.toString(sum,'n2','es-PE')#" },
                { field: "SaldoSol", width: 80,attributes:{style:"text-align:right;"}, title: "Saldo S/.", footerTemplate: "<div style='float: right'>Total: #=kendo.toString(sum,'n2','es-PE')#" }
                //{ field: "Concepto", width: 190, title: "Concepto" },
                //{ field: "importe", width: 100, title: "Importe S/." },
                //{ field: "fecha_registro", width: 130, title: "Fecha Registro" },
                //{ field: "fecha_sistema", width: 130, title:"Fecha Sistema" }
            ]
        });
    });
</script>

<?php
/*
 * Desarrollador    : Cesar Mamani Dominguez
 * Fecha Creación   : 2013.06.28
 * 
 * Desarrollador    : [Desarrollador]
 * Fecha Edición    : [yyyy.mm.dd]
 * 
 * Descripción      : Reporte Movimiento de saldo hecho integramente en kendo.
 */
?>
<style>
 span.k-timepicker, span.k-datetimepicker, span.k-datepicker {width: auto;}   .k-grid-content{overflow-y: hidden;}
 .k-grid-header{padding-right: 0px !important;}
 .k-grid-footer{padding-right: 0px !important;}
 .k-grid .k-group-col, .k-grid .k-hierarchy-col {width: 0.1px !important;} 

</style>
<div id="main_container">
    <div class="row-fluid">
        <div class="form-row row-fluid">
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.caj') ?></label>
            <div class="controls span3">
                <input id="cb_caja" name="cb_caja" class="row-fluid" />                   
            </div> 
        </div>
        <div class="form-row row-fluid">
             <label for="normal-field" class="control-label span2"><?= lang('rptmov.proy') ?></label>
            <div class="controls span3">
                <input id="cb_proyecto" name="cb_proyecto" class="row-fluid" />                   
            </div> 
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.subproy') ?></label>
            <div class="controls span3">
                <input id="cb_subproyecto" name="cb_subproyecto" class="row-fluid" />                   
            </div> 
         </div>
        <div class="form-row row-fluid">
             <label for="normal-field" class="control-label span2"><?= lang('rptmov.conc') ?></label>
            <div class="controls span3">
                <input id="cb_concepto" name="cb_concepto" class="row-fluid" />           
            </div>
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.subconc') ?></label>
            <div class="controls span3">
                <input id="cb_subconcepto" name="cb_subconcepto" class="row-fluid" />           
            </div>
         </div>
                <div class="form-row row-fluid">
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.fch_ini') ?></label>
            <div class="controls span3">
                <input  id="txt_fec_ini" name="txt_fec_ini" value="" />
            </div>
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.fch_fin') ?></label>
            <div class="controls span3">
                <input  id="txt_fec_fin" name="txt_fec_fin" value="" />
            </div>
         </div>
        <br>
   <div class="form-row row-fluid">
       <a id="btnVer" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.view') ?></a>
       <a id="btnLimpiar" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.limp')?></a>
       <a id="btnExportar" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.export')?></a>
       <a id="btnImprimir" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.print')?></a>
       <div id="dlgNew" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       </div>
       <br>
       <br>
       <center>
            <div id="tbSaldos" style="width: 550px;">
            </div>
       </center>
       <br>
       <br>
       <div id="tbData">
       </div>
    </div>
</div>
    
    
</div>
<script type="text/javascript">
    
    var tituloInformacion = "<?= lang('g.titleMsgInfo')?>";
$(document).ready(function() {
   var cb_subproyecto , cb_subconcepto ; 
   $.populateComboBox('#cb_caja', "<?= lang('rptmov.selectall') ?>", 'Caja', 'c_codigo',<?php echo (isset($jsonCajas)) ? $jsonCajas : 'null' ?>,1 );
   
   $.populateComboBox('#cb_proyecto', "<?= lang('rptmov.selectall') ?>", 'Proyecto', 'id_proyecto',<?php echo (isset($jsonProyectos)) ? $jsonProyectos : 'null' ?>,1 );
   
    cb_subproyecto = $("#cb_subproyecto").kendoComboBox({
     autoBind: false,
     cascadeFrom: "cb_proyecto",
     placeholder: "<?= lang('rptmov.selectall') ?>",
     dataTextField: "Codigo",
     dataValueField: "id_proyecto",
     dataSource: {
         serverFiltering: true,
         transport: {
             read: {
                 dataType: "json",                        
                 url: "<?= site_url('reportemov/get_subproyecto_by_proyecto') ?>"
             }
         }
     }
     }).data("kendoComboBox");
     
    $.populateComboBox('#cb_concepto', "<?= lang('rptmov.selectall') ?>", 'Concepto', 'id_concepto',<?php echo (isset ($jsonConceptos)) ? $jsonConceptos : 'null' ?>,1 );
     
     cb_subconcepto = $("#cb_subconcepto").kendoComboBox({
     autoBind: false,
     cascadeFrom: "cb_concepto",
     placeholder: "<?= lang('rptmov.selectall') ?>",
     dataTextField: "Codigo",
     dataValueField: "id_concepto",
     dataSource: {
         serverFiltering: true,
         transport: {
             read: {
                 dataType: "json",                        
                 url: "<?= site_url('reportemov/get_subconcepto_by_concepto') ?>"
             }
         }
     }
     }).data("kendoComboBox");
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
           var dpFechaI = $("#txt_fec_ini").kendoDatePicker({
               change: startChange,
               format: "yyyy/MM/dd"
           }).data("kendoDatePicker"); 
           var dpFechaF = $("#txt_fec_fin").kendoDatePicker({
               change: endChange,
               format: "yyyy/MM/dd"
           }).data("kendoDatePicker");
           
            dpFechaI.max(dpFechaF.value());
            dpFechaF.min(dpFechaI.value());
     function printGrid() {
    var gridElementS = $("#tbSaldos"), gridElement = $("#tbData"),
        win = window.open('', '', 'width= ' + screen.width + ' height= ' + screen.height + ', fullscreen'),
        doc = win.document.open(),
        htmlStart = 
            '<!DOCTYPE html>' +
            '<html>' +
            '<head>' +
            '<meta charset="utf-8" />' +
            '<title>Reporte de Movimiento por fecha de Sistema</title>' + 
            '<link href="http://cdn.kendostatic.com/' + kendo.version + '/styles/kendo.common.min.css" rel="stylesheet" media="print" /> '+
            '<style>' +
            'html { font: 11pt sans-serif; }' +
            'a:link {text-decoration:none;color:black;}' + 
            '.k-selectable{width: 100%;}' +
            '.k-header{border: solid 1px #000000;background-color: #D2D2D2;}'+
            '.k-grouping-row{border: solid 1px #000000;background-color: #B4B4B4;border-style: solid;border-color:#ff0000 #0000ff;}'+
            '.k-grid, .k-grid-content { height: auto !important; border: solid 1px #000000;}' +
            '.k-grid-toolbar, .k-grid-pager > .k-link { display: none; border: solid 1px #000000;}' +
            '.k-grid-header{width: 100%;}'+ '.k-grid-footer{width: 100%;}'+
            '.k-group-footer{border: solid 1px #000000;background-color: #D2D2D2;}'+
            '.k-group-cell{border: solid 1px #000000;padding-left: 62px;width: 4%;}'+
            'td{border: solid 1px #000000;'+
            '</style>' +
            '</head>' + 
            '<body><div><center><b>REPORTE DE MOVIMIENTO POR FECHA DE SISTEMA ' + $("#txt_fec_ini").val() + ' - ' + $("#txt_fec_fin").val() +
            ' </b></center></div><center><br><br>',
                    htmlEnd = 
            '</center></body>' +
            '</html>';

            doc.write(htmlStart + gridElementS.clone()[0].outerHTML + '<br>' + gridElement.clone()[0].outerHTML + htmlEnd);
            doc.close();
            win.print();
        }
          
     /* dataSorce Saldos */
        var dataSaldos = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('reportemov/get_reportemov_sum') ?>",
                        success: function (resultado){
                            options.success(resultado);
                        }
                    });
                }
            },
            error: function(e) {
                alert('<?= lang('error.trans') ?>');
            },
            pageSize: 0,
            schema: {
                model: {
                    fields: {
                        TITULO:                 { type: "string" },
                        IMPORTE_SUM:            { type: "number" },
                        IMPORTE_DOL_SUM:        { type: "number" }
                    }
                }
            },
            aggregate: [{ field: "IMPORTE_SUM",  aggregate: "sum" },
                         { field: "IMPORTE_DOL_SUM", aggregate: "sum" }]
        });
        $("#tbSaldos").kendoGrid({
            dataSource: dataSaldos,
            selectable: "row",
            sortable: false,
            filterable: false,
            pageable: false,
            scrollable:false,
            height: 142,
            columns: [ 
                { field: "TITULO", width: 'auto', title: " ", footerTemplate: "Saldo Final"},
                { field: "IMPORTE_SUM", width: 'auto', format  : "{0:n2}", attributes:{style:"text-align:right"}, title: "Importe Soles", footerTemplate: "<div style='float: right'> #=kendo.toString(sum,'n2','es-PE')#"},
                { field: "IMPORTE_DOL_SUM", width: 'auto', format  : "{0:n2}", attributes:{style:"text-align:right"}, title: "Importe Dolares", footerTemplate: "<div style='float: right'> #=kendo.toString(sum,'n2','es-PE')#"},
            ]
            
        });
     /**/
     
     /***FIN BOTON***/
     
     /** FIN_FECHAS **/
     
            /****** inicio datasource **/
         var dataSource = new kendo.data.DataSource({
            transport: {
                read: { 
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('reportemov/get_reportemov_list') ?>",
                        success: 
                              function (resultado){
                               options.success(resultado);
                        }
                        ,
                        error   : function () {
                        
                        jAlert('Error al recibir datos de la tabla!', tituloInformacion);
                        }
                }
            },
            error: function() {
                jAlert('Error al cargar datos de la tabla!', tituloInformacion);
            },
            pageSize: 0,
            schema: {
                model: {
                    id: "id_transaccion",
                    fields: {
                        TITULO:         { type: "string" },
                        id_transaccion: { type: "number" },
                        fecha_sistema:  { type: "string" },
                        CUENTA_DB:      { type: "string" },
                        CUENTA_CR:      { type: "string" },
                        EMPRESA:        { type: "string" },
                        EMPRESA_DB:     { type: "string" },
                        EMPRESA_CR:     { type: "string" },
                        c_caja:         { type: "string" },
                        c_concepto:     { type: "string" },
                        c_sconcepto:    { type: "string" },
                        observacion:    { type: "string" },
                        rendicion:      { type: "string" },
                        IMPORTE:        { type: "number" },
                        IMPORTE_DOL:    { type: "number" }
                    }
                }
            },
            group: { field: "TITULO", 
                     aggregates: [{ field: "TITULO", aggregate: "count" },
                                  
                                  { field: "IMPORTE", aggregate: "sum" },
                                  { field: "IMPORTE_DOL", aggregate: "sum" }]
            },
            aggregate: [{ field: "TITULO", aggregate: "count" },
                        { field: "TITULO", aggregate: "sum" },
                        { field: "IMPORTE", aggregate: "sum" },
                        { field: "IMPORTE_DOL", aggregate: "sum" }]
});
     /*** FIN_DATASOURCE ***/

   $('#btnVer').click(function (e){
        e.preventDefault();
        var cb_caja     = $('#cb_caja').data("kendoComboBox");
        var cb_proyecto = $('#cb_proyecto').data("kendoComboBox");
        var cb_concepto = $('#cb_concepto').data("kendoComboBox");

         var URL= "reportemov/load_reporte/";
         
         if(cb_proyecto.value() == "")
             URL = URL + "-1" + "/";
         else
             URL = URL + cb_proyecto.value() + "/";
         if(cb_subproyecto.value() == "")
             URL = URL + "-1" + "/";
         else
             URL = URL + cb_subproyecto.value() + "/"; 
         if(cb_concepto.value() =="")
             URL = URL + "-1" + "/";
         else
             URL = URL + cb_concepto.value()+ "/";
         if(cb_subconcepto.value() =="")
             URL = URL + "-1" + "/";
         else
             URL = URL + cb_subconcepto.value() + "/";
         if(cb_caja.value() =="") // Añadido nuevo combo caja
             URL = URL + "-1" ;
         else
             URL = URL + cb_caja.value();
         if($("#txt_fec_ini").val() !== '' )
            URL = URL + "/" + castFecha($("#txt_fec_ini").val()) ;
        else
            URL = URL + "/" + "SF" ;
        if($("#txt_fec_fin").val() !== '')
            URL = URL + "/"  + castFecha($("#txt_fec_fin").val());
        else
            URL = URL + "/" + "SF" ;
        
        $.ajax({
             type: "POST",
             dataType: "html",
             url:URL,
             beforeSend: function(){
                $("#btnVer").attr("disabled", "disabled");
                $("#btnVer").html("<?= lang('g.msgProcesing')?>");
             },
             success: function(){
                $('#tbData').data("kendoGrid").dataSource.read();
                    $("#btnVer").attr("disabled", "disabled");
                    $("#btnVer").html("<?= lang('g.msgProcesing')?>");  
             },
             error: function(){
                jAlert('Error dentro de la grilla!', tituloInformacion);
             },
             complete: function(){
               $("#btnVer").removeAttr("disabled");
               $("#btnVer").html("<?= lang('boton.view') ?>");
               $('#tbSaldos').data("kendoGrid").dataSource.read();
             }
         });

        $("#tbData").kendoGrid({
            dataSource: dataSource,
            selectable: "row",
            sortable: true,
            filterable: false,
            width: "auto",
            scrollable: true,

            reorderable: true,
            resizable: true,

            change: function() {
//                var selected = this.select()
//                    dataS = dataSource.getByUid(selected.data("uid"));
//                     nroT = dataS.id_transaccion;  
            var grid = $("#tbData").data("kendoGrid");
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_transaccion;
                var param = {id : id};
                //console.log(param);                
                $.openModal('#btnEdit', 'reportemov/view_movimiento', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Movimiento');
                //console.log("No hay dato");                
            }
                //console.log(nroT);
            },       
            pageable: false,
            columns: [
                { field: "TITULO",
                  hidden: true,
                  title: "Titulo agrupado: ",
                  groupHeaderTemplate: "#=value# (Nro. de Transacciones: #=count#) "
                },//titulo
                { field: "id_transaccion",
                  width: 25,
                  title: "<div style='font-size: 12px; width: 27px;'>Id</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "fecha_sistema",
                  width: 35,
                  title: "<div style='font-size: 10px; width: 49px;'>Fecha</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "CUENTA_DB",
                  width: 35,
                  title: "<div style='font-size: 10px; width: 33px;'>Cue._DB</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "CUENTA_CR",
                  width: 35,
                  title: "<div style='font-size: 10px; width: 32px;'>Cue._CR</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "EMPRESA",
                  width: 30,
                  title: "<div style='font-size: 12px;width: 28px;'>Empr.</div>",
                  attributes:{style:"font-size: 9px"} 
                },
                { field: "EMPRESA_DB",
                  width: 40,
                  title: "<div style='font-size: 10px;width: 38px;'>Empr._DB</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "EMPRESA_CR",
                  width: 40,
                  title: "<div style='font-size: 10px; width: 38px;'>Empr._CR</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "c_caja",
                  width: 60,
                  title: "<div style='font-size: 12px; width: 58px; text-align:center;'>Caja</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "c_concepto",
                  width: 45,
                  title: "<div style='font-size: 12px; width: 53px;'>Concepto</div>",
                  attributes:{style:"font-size: 9px"} 
                },
                { field: "c_sconcepto",
                  width: 45,
                  title: "<div style='font-size: 12px; width: 70px;'>Subconcep.</div>",
                  attributes:{style:"font-size: 9px"}
                },
                { field: "rendicion",
                  width: 40,
                  title: "<div style='font-size: 12px; width: 42px;'>Rendicion</div>",
                  attributes:{style:"font-size: 9px"},
                  footerTemplate: "Importe ",
                  groupFooterTemplate: "Sub "
                },
                { field: "observacion",
                  width: 100,
                  title: "<div style='font-size: 12px; width: 101px;'>Observacion</div>" ,
                  attributes:{style:"font-size: 9px"},
                  footerTemplate: "Total: ",
                  groupFooterTemplate: "Total: "
                },
                { field: "IMPORTE", 
                  width: 40,
                  title: "<div style='font-size: 11px; width: 50px;'>Importe_S/.</div>" ,
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 11px"},
                  groupHeaderTemplate: "Valor: #=value# ",
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                  
                },
                { field: "IMPORTE_DOL",
                  width: 40,
                  title: "<div style='font-size: 11px; width: 47px;'>Importe_$</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 11px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                  
                },
            ]
        });
    });

 $("#btnExportar").click(function(e) {
     
     var data = $("#tbData").data("kendoGrid").dataSource.data();
     var result = "data:application/vnd.ms-excel,";
     // result += "<style>td{border: solid 1px #000000;</style>";
     result += "<table><tr><th>Proyecto - Subproy.</th><th>ID</th><th>Fecha</th><th>Central DB</th><th>Central CR</th><th>Emp.</th><th>Empresa DB</th><th>Empresa CR</th><th>Caja</th><th>Concepto</th><th>Subconcepto</th><th>Rendicion</th><th>Observacion</th><th>Importe S/.</th><th>Importe US$</th></tr>";
     
     for (var i = 0; i < data.length; i++) {
         result += "<tr>";
         
         result += "<td>";
         result += data[i].TITULO;
         result += "</td>";
         
         result += "<td>";
         result += data[i].id_transaccion;
         result += "</td>";
         
         result += "<td>";
         result += kendo.format("{0:MM/dd/yyyy}", data[i].fecha_sistema);
         result += "</td>";
         
         result += "<td>";
         result += data[i].CUENTA_DB;
         result += "</td>";

         result += "<td>";
         result += data[i].CUENTA_CR;
         result += "</td>";
         
         result += "<td>";
         result += data[i].EMPRESA;
         result += "</td>";

         result += "<td>";
         result += data[i].EMPRESA_DB;
         result += "</td>";
         
         result += "<td>";
         result += data[i].EMPRESA_CR;
         result += "</td>";

         result += "<td>";
         result += data[i].c_caja;
         result += "</td>";

         result += "<td>";
         result += data[i].c_concepto;
         result += "</td>";

         result += "<td>";
         result += data[i].c_sconcepto;
         result += "</td>";

         result += "<td>";
         result += data[i].rendicion;
         result += "</td>";

         result += "<td>";
         result += data[i].observacion;
         result += "</td>";

         result += "<td>";
         result += data[i].IMPORTE;
         result += "</td>";

         result += "<td>";
         result += data[i].IMPORTE_DOL;
         result += "</td>";


         result += "</tr>";
     }
     
     result += "</table>";
     window.open(result);
     
     e.preventDefault();
});
    $("#btnImprimir").click(function(){
        printGrid();
    });
     $('#btnLimpiar').click(function () {
       $('#cb_caja').data("kendoComboBox").text('');
       $('#cb_proyecto').data("kendoComboBox").text('');
       cb_subproyecto.text('');
       $('#cb_concepto').data("kendoComboBox").text('');
       cb_subconcepto.text('');
       $('#txt_fec_ini').val('');
       $('#txt_fec_fin').val('');
    });

});
   function castFecha(fecha){
        if(fecha === '')
            return '';
        var arrayfecha = fecha.split('/');
            fecha = arrayfecha[0] + arrayfecha[1] + arrayfecha[2];
        return fecha;
    }
</script>

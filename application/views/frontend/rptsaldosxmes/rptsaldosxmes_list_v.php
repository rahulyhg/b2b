<?php
/*
 * Desarrollador    : 
 * Fecha Creación   : 2013.07.28
 * 
 * Desarrollador    : [Desarrollador]
 * Fecha Edición    : [yyyy.mm.dd]
 * 
 * Descripción      : 
 */
?>
<style>
span.k-timepicker, span.k-datetimepicker, span.k-datepicker {width: auto;}
.k-grid-content{overflow-y: hidden;}
.k-grid-header{padding-right: 0px !important;}
.k-grid-footer{padding-right: 0px !important;}
.k-grid .k-group-col, .k-grid .k-hierarchy-col {width: 0.1px !important;}

</style>
<div id="main_container">
    <div class="row-fluid">
        <!--<div class="form-row row-fluid">
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.caja') ?></label>
            <div class="controls span3">
                <input id="cb_caja" name="cb_caja" class="row-fluid" />                   
            </div> 
        </div>
        <div class="form-row row-fluid">
             <label for="normal-field" class="control-label span2"><?= lang('rptmov.proy') ?></label>
            <div class="controls span3">
                <input id="cb_proyecto" name="cb_proyecto" class="row-fluid" />                   
            </div> 
            <label for="normal-field" class="control-label span2"><?= lang('rptmov.conc') ?></label>
            <div class="controls span3">
                <input id="cb_concepto" name="cb_concepto" class="row-fluid" />           
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
         </div>-->
         <div class="form-row row-fluid">
<!--            <label for="normal-field" class="control-label span2"><?= lang('rptsaldosxmes.fecha') ?></label>
            <div class="controls span3">
                <input  id="txt_fecha" name="txt_fec_fin" value="" />
            </div>-->
            
            <label for="normal-field" class="control-label span1"><?= lang('rptsaldosxmes.fecha') ?></label>
            <div class="controls span3">
                    <input id="txt_fecha" name="txt_fec_fin" value="2013" style="width:150px" />
            </div>
            
        </div>
        <br>
   <div class="form-row row-fluid">
       <a id="btnVer" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.view') ?></a>
       <!--<a id="btnLimpiar" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.limp')?></a>-->
       <a id="btnExportar" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.export')?></a>
       <a id="btnImprimir" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.print')?></a>
       <!--<a id="btnSaldos" href="#" class="btn btn-secondary color_14" data-toggle="modal">Saldos</a>-->
       
       <div id="dlgNew" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <!-- Div donde cargarán los fomularios -->
       </div>
       <br>
       <br>
       <div id="tbData">
       <!-- Div donde cargarán el reporte -->
       </div>
       <br>
       <br>
       <div id="tbData2">
       <!-- Div donde cargarán el reporte -->
       </div>
    </div>
</div>
    
    
</div>
<script type="text/javascript">
    
    var tituloInformacion = "<?= lang('g.titleMsgInfo')?>";
$(document).ready(function() {
    
    //$.populateComboBox('#cb_caja', "<?= lang('rptcajaemp.selectall') ?>", 'Caja', 'c_codigo',<?php echo (isset($jsonCajas)) ? $jsonCajas : 'null' ?>,1 );
   
    //$.populateComboBox('#cb_proyecto', "<?= lang('rptcajaemp.selectall') ?>", 'Proyecto', 'id_proyecto',<?php echo (isset($jsonProyectos)) ? $jsonProyectos : 'null' ?>,1 );
   
    //$.populateComboBox('#cb_concepto', "<?= lang('rptmov.selectall') ?>", 'Concepto', 'id_concepto',<?php echo (isset ($jsonConceptos)) ? $jsonConceptos : 'null' ?>,1 );
    
     
     /** FECHAS **/
     /*
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
               format: "dd-MM-yyyy"
           }).data("kendoDatePicker"); 

            // Datepicker
           var dpFechaF = $("#txt_fec_fin").kendoDatePicker({
               change: endChange,
               format: "dd-MM-yyyy"
           }).data("kendoDatePicker");
           
            dpFechaI.max(dpFechaF.value());
            dpFechaF.min(dpFechaI.value());
//            readOnly('txt_fec_ini');
//            readOnly('txt_fec_fin');
     
     /***BOTON IMPRESION***/
     /* YEARPICKER */
     $("#txt_fecha").kendoDatePicker({
                    // defines the start view
                    start: "decade",

                    // defines when the calendar should return date
                    depth: "decade",

                    // display month and year in the input
                    format: "yyyy"
     });
     /* FIN YEARPICKER */
     function printGrid() {
     var gridElement = $("#tbData"),
        win = window.open('', '', 'width=800, height=500'),
        doc = win.document.open(),
        htmlStart = 
            '<!DOCTYPE html>' +
            '<html>' +
            '<head>' +
            '<meta charset="utf-8" />' +
            '<title>Reporte de Saldos por Año</title>' +
            '<link href="http://cdn.kendostatic.com/' + kendo.version + '/styles/kendo.common.min.css" rel="stylesheet" /> '+
            '<style>' +
            'html { font: 11pt sans-serif; }' +
            '.k-grid, .k-grid-content { height: auto !important; }' +
            '.k-grid-toolbar, .k-grid-pager > .k-link { display: none; }' +
            '</style>' +
            '</head>' +
            '<body>',
        htmlEnd = 
            '</body>' +
            '</html>';

            doc.write(htmlStart + gridElement.clone()[0].outerHTML + htmlEnd);
            doc.close();
            win.print();
        }
     
     /***FIN BOTON***/
     
     /** FIN_FECHAS **/
     
     /**/
     
   $('#btnVer').click(function (e){
        e.preventDefault();
        
        var URL= "rptsaldosxmes/load_reporte/";
         
        if($("#txt_fecha").val() !== '')
            URL = URL + "/"  + $("#txt_fecha").val();
        else
            URL = URL + "/" + "-1" ;
        
        $.ajax({
             type: "POST",
             dataType: "html",
             url:URL,
             beforeSend: function(){
                $("#btnVer").attr("disabled", "disabled");
                $("#btnVer").html("<?= lang('g.msgProcesing')?>");
                //$("#btnSaldos").attr("disabled", "disabled");
             },
             success: function(){

                $('#tbData').data("kendoGrid").dataSource.read();
                $('#tbData2').data("kendoGrid").dataSource.read();
                    $("#btnVer").attr("disabled", "disabled");
                    $("#btnVer").html("<?= lang('g.msgProcesing')?>"); 
                        
             },
             error: function(){
                jAlert('Error dentro de la grilla!', tituloInformacion);
             },
             complete: function(){
               $("#btnVer").removeAttr("disabled");
               $("#btnVer").html("<?= lang('boton.view') ?>");
               
        
               //$('#tbSaldos').data("kendoGrid").dataSource.read();
               //$("#btnSaldos").removeAttr("disabled");
              // if( $('#tbData').data("kendoGrid").dataSource.data().length > 0){rgrid = 1;};
               //console.log($('#tbData').data("kendoGrid").dataSource.data().length);
             }
         });
         
//            function resizeGrid() {
//                var gridElement = $("#tbData"),
//                    dataArea = gridElement.find(".k-grid-content"),
//                    gridHeight = gridElement.innerHeight(),
//                    otherElements = gridElement.children().not(".k-grid-content"),
//                    otherElementsHeight = 0;
//                otherElements.each(function(){
//                    otherElementsHeight += $(this).outerHeight();
//                });
//                dataArea.height(gridHeight - otherElementsHeight);
//            }
//            $(window).resize(function(){
//                resizeGrid();
//            });
//
//       if(rgrid != 0){
//       $("#tbData").html("<div style='border: 2px solid #FE971C; margin-top: 20px; padding: 7px; width: 93%;'> No hay datos para mostrar</div>");
//       $("#btnVer").removeAttr("disabled");
//               $("#btnVer").html("<//?= lang('boton.view') ?>");
//        }else{

            /****** inicio datasource **/
         var dataSource = new kendo.data.DataSource({
            transport: {
                read: { 
//                    function(options){
//                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('rptsaldosxmes/get_reportemov_list') ?>",
                        success: 
                              function (resultado){
                               options.success(resultado);
                        }
                        ,
                        error   : function () {
                        
                        //options.error(resultado);
                        jAlert('Error al recibir datos de la tabla!', 
                            tituloInformacion);
                        }
//                    });
                }
            },
            error: function() {
                //console.log('ERROR2');
                jAlert('Error al cargar datos de la tabla!', 
                    tituloInformacion);
            },
            pageSize: 0,
            schema: {
                model: {
                    id: "Cuenta",
                    fields: {
                        TITULO:        { type: "string" },
                        Cuenta:        { type: "number" },
                        Descripcion:   { type: "string" },
                        SInicial:      { type: "number" },
                        Ene:           { type: "number" },
                        Feb:           { type: "number" },
                        Mar:           { type: "number" },
                        Abr:           { type: "number" },
                        May:           { type: "number" },
                        Jun:           { type: "number" },
                        Jul:           { type: "number" },
                        Ago:           { type: "number" },
                        Sep:           { type: "number" },
                        Oct:           { type: "number" },
                        Nov:           { type: "number" },
                        Dic:           { type: "number" },
                        Ajuste:        { type: "number" },
                        Cierre:        { type: "number" },
                        SFinal:        { type: "number" }
                    }
                }
            },
            group: { field: "TITULO",
                    aggregates: [{ field: "TITULO", aggregate: "count" },
                                 { field: "SInicial", aggregate: "sum" },
                                 { field: "Ene", aggregate: "sum" },
                                 { field: "Feb", aggregate: "sum" },
                                 { field: "Mar", aggregate: "sum" },
                                 { field: "Abr", aggregate: "sum" },
                                 { field: "May", aggregate: "sum" },
                                 { field: "Jun", aggregate: "sum" },
                                 { field: "Jul", aggregate: "sum" },
                                 { field: "Ago", aggregate: "sum" },
                                 { field: "Sep", aggregate: "sum" },
                                 { field: "Oct", aggregate: "sum" },
                                 { field: "Nov", aggregate: "sum" },
                                 { field: "Dic", aggregate: "sum" },
                                 { field: "Ajuste", aggregate: "sum" },
                                 { field: "Cierre", aggregate: "sum" },
                                 { field: "SFinal", aggregate: "sum" }
                                ]
            },
            
            aggregate: [
                        { field: "TITULO", aggregate: "count"},
                        { field: "SInicial", aggregate: "sum" },
                        { field: "Ene", aggregate: "sum" },
                        { field: "Feb", aggregate: "sum" },
                        { field: "Mar", aggregate: "sum" },
                        { field: "Abr", aggregate: "sum" },
                        { field: "May", aggregate: "sum" },
                        { field: "Jun", aggregate: "sum" },
                        { field: "Jul", aggregate: "sum" },
                        { field: "Ago", aggregate: "sum" },
                        { field: "Sep", aggregate: "sum" },
                        { field: "Oct", aggregate: "sum" },
                        { field: "Nov", aggregate: "sum" },
                        { field: "Dic", aggregate: "sum" },
                        { field: "Ajuste", aggregate: "sum" },
                        { field: "Cierre", aggregate: "sum" },
                        { field: "SFinal", aggregate: "sum" }]
});
     /*** FIN_DATASOURCE ***/
        $("#tbData").kendoGrid({
            dataSource: dataSource,
            selectable: "row",
            sortable: true,
            filterable: false,
            width: "auto",
            scrollable: true,

            reorderable: true,
            resizable: true,
            pageable: false,
            
            columns: [
                { field: "TITULO",
                  hidden: true,
                  title: "Titulo agrupado: ",
                  groupHeaderTemplate: "#=value# (Nro. de cuentas: #=count#) "
                },//titulo
                { field: "Cuenta",
                  //width: 15,
                  title: "<div style='font-size: 12px'>Cuenta</div>",
                  attributes:{style:"font-size: 12px"},
                  groupFooterTemplate: "<div style='float:right'>Sub "
                },
                { field: "Descripcion",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Caja</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"font-size: 11px"},
                  footerTemplate: "Importe Total: ",
                  groupFooterTemplate: "Total: "
                  
                },
                { field: "SInicial",
                  //width: 20,
                  title: "<div style='font-size: 12px'>S.Inicial</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Ene",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Ene</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Feb",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Feb</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Mar",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Mar</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Abr",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Abr</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "May",
                  //width: 20,
                  title: "<div style='font-size: 12px'>May</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Jun",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Jun</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Jul",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Jul</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Ago",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Ago</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Sep",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Sep</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Oct",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Oct</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Nov",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Nov</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Dic",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Dic</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Ajuste",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Ajuste</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Cierre",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Cierre</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "SFinal",
                  //width: 20,
                  title: "<div style='font-size: 12px'>S.Final</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
            ]
        });
        
        /****** inicio datasource 2 **/
         var dataSource2 = new kendo.data.DataSource({
            transport: {
                read: { 
//                    function(options){
//                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('rptsaldosxmes/get_reportemov_list2') ?>",
                        success: 
                              function (resultado){
                               options.success(resultado);
                        }
                        ,
                        error   : function () {
                        
                        //options.error(resultado);
                        jAlert('Error al recibir datos de la tabla!', 
                            tituloInformacion);
                        }
//                    });
                }
            },
            error: function() {
                //console.log('ERROR2');
                jAlert('Error al cargar datos de la tabla!', 
                    tituloInformacion);
            },
            pageSize: 0,
            schema: {
                model: {
                    id: "Cuenta",
                    fields: {
                        TITULO:        { type: "string" },
                        Cuenta:        { type: "number" },
                        Descripcion:   { type: "string" },
                        SInicial:      { type: "number" },
                        Ene:           { type: "number" },
                        Feb:           { type: "number" },
                        Mar:           { type: "number" },
                        Abr:           { type: "number" },
                        May:           { type: "number" },
                        Jun:           { type: "number" },
                        Jul:           { type: "number" },
                        Ago:           { type: "number" },
                        Sep:           { type: "number" },
                        Oct:           { type: "number" },
                        Nov:           { type: "number" },
                        Dic:           { type: "number" },
                        Ajuste:        { type: "number" },
                        Cierre:        { type: "number" },
                        SFinal:        { type: "number" }
                    }
                }
            },
            group: { field: "TITULO",
                    aggregates: [{ field: "TITULO", aggregate: "count" },
                                 { field: "SInicial", aggregate: "sum" },
                                 { field: "Ene", aggregate: "sum" },
                                 { field: "Feb", aggregate: "sum" },
                                 { field: "Mar", aggregate: "sum" },
                                 { field: "Abr", aggregate: "sum" },
                                 { field: "May", aggregate: "sum" },
                                 { field: "Jun", aggregate: "sum" },
                                 { field: "Jul", aggregate: "sum" },
                                 { field: "Ago", aggregate: "sum" },
                                 { field: "Sep", aggregate: "sum" },
                                 { field: "Oct", aggregate: "sum" },
                                 { field: "Nov", aggregate: "sum" },
                                 { field: "Dic", aggregate: "sum" },
                                 { field: "Ajuste", aggregate: "sum" },
                                 { field: "Cierre", aggregate: "sum" },
                                 { field: "SFinal", aggregate: "sum" }
                                ]
            },
            
            aggregate: [
                        { field: "TITULO", aggregate: "count"},
                        { field: "SInicial", aggregate: "sum" },
                        { field: "Ene", aggregate: "sum" },
                        { field: "Feb", aggregate: "sum" },
                        { field: "Mar", aggregate: "sum" },
                        { field: "Abr", aggregate: "sum" },
                        { field: "May", aggregate: "sum" },
                        { field: "Jun", aggregate: "sum" },
                        { field: "Jul", aggregate: "sum" },
                        { field: "Ago", aggregate: "sum" },
                        { field: "Sep", aggregate: "sum" },
                        { field: "Oct", aggregate: "sum" },
                        { field: "Nov", aggregate: "sum" },
                        { field: "Dic", aggregate: "sum" },
                        { field: "Ajuste", aggregate: "sum" },
                        { field: "Cierre", aggregate: "sum" },
                        { field: "SFinal", aggregate: "sum" }]
});
     /*** FIN_DATASOURCE 2***/
        $("#tbData2").kendoGrid({
            dataSource: dataSource2,
            selectable: "row",
            sortable: true,
            filterable: false,
            width: "auto",
            scrollable: true,

            reorderable: true,
            resizable: true,
            pageable: false,
            
            columns: [
                { field: "TITULO",
                  hidden: true,
                  title: "Titulo agrupado: ",
                  groupHeaderTemplate: "#=value# (Nro. de cuentas: #=count#) "
                },//titulo
                { field: "Cuenta",
                  //width: 15,
                  title: "<div style='font-size: 12px'>Cuenta</div>",
                  attributes:{style:"font-size: 12px"},
                  groupFooterTemplate: "<div style='float:right'>Sub "
                },
                { field: "Descripcion",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Caja</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"font-size: 11px"},
                  footerTemplate: "Importe Total: ",
                  groupFooterTemplate: "Total: "
                  
                },
                { field: "SInicial",
                  //width: 20,
                  title: "<div style='font-size: 12px'>S.Inicial</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Ene",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Ene</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Feb",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Feb</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Mar",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Mar</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Abr",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Abr</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "May",
                  //width: 20,
                  title: "<div style='font-size: 12px'>May</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Jun",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Jun</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Jul",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Jul</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Ago",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Ago</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Sep",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Sep</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Oct",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Oct</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Nov",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Nov</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Dic",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Dic</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Ajuste",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Ajuste</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "Cierre",
                  //width: 20,
                  title: "<div style='font-size: 12px'>Cierre</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
                { field: "SFinal",
                  //width: 20,
                  title: "<div style='font-size: 12px'>S.Final</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                },
            ]
        });

//        }
        /****** fin grilla ***/
    });
        /** Fin evento del boton ver **/
       /*
       // boton detalles
        $('#btnDetail').on('click', (function() {
            var grid = $("#tbData").data("kendoGrid");
            var row = grid.select();
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).id_transaccion;
                var param = {id : id};
                $.openModal('#btnDetail', 'rptcajaemp/view_movimiento', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Transacción');
            }
        }));
       */
//      INICIO EVENTO BOTON IMPRIMIR

 $("#btnExportar").click(function(e) {
     
     var data = $("#tbData").data("kendoGrid").dataSource.data();
     var result = "data:application/vnd.ms-excel,";
     
     result += "<table><tr><th>Cuenta</th><th>Descripcion</th><th>S. Inicial</th><th>Enero</th><th>Febrero</th><th>Marzo</th><th>Abril</th><th>Mayo<th>Junio</th><th>Julio</th><th>Agosto</th><th>Setiembre</th><th>Octubre</th><th>Noviembre</th><th>Diciembre</th><th>Ajuste</th><th>Cierre</th><th>S. final</th></tr>";
     
     for (var i = 0; i < data.length; i++) {
         result += "<tr>";
         
//         result += "<td>";
//         result += data[i].TITULO;
//         result += "</td>";
//


         result += "<td>";
         result += data[i].Cuenta;
         result += "</td>";
         
         result += "<td>";
         result += data[i].Descripcion;
         result += "</td>";
         

         result += "<td>";
         result += data[i].SInicial;
         result += "</td>";

         result += "<td>";
         result += data[i].Ene;
         result += "</td>";

         result += "<td>";
         result += data[i].Feb;
         result += "</td>";

         result += "<td>";
         result += data[i].Mar;
         result += "</td>";

         result += "<td>";
         result += data[i].Abr;
         result += "</td>";

         result += "<td>";
         result += data[i].May;
         result += "</td>";

         result += "<td>";
         result += data[i].Jun;
         result += "</td>";

         result += "<td>";
         result += data[i].Jul;
         result += "</td>";

         result += "<td>";
         result += data[i].Ago;
         result += "</td>";
         
         result += "<td>";
         result += data[i].Sep;
         result += "</td>";
         
         result += "<td>";
         result += data[i].Oct;
         result += "</td>";

         result += "<td>";
         result += data[i].Nov;
         result += "</td>";

         result += "<td>";
         result += data[i].Dic;
         result += "</td>";

         result += "<td>";
         result += data[i].Ajuste;
         result += "</td>";

         result += "<td>";
         result += data[i].Cierre;
         result += "</td>";
         
         result += "<td>";
         result += data[i].SFinal;
         result += "</td>";


         result += "</tr>";
     }
     
     result += "</table>";
     window.open(result);
     
     e.preventDefault();
});

/*
        $('#btnSaldos').on('click', (function() {
            var param = null;
            $.openModal('#btnSaldos', 'rptcajaemp/saldo_reptcajaemp', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
        }));
 */
//      FIN EVENTO BOTON EXPORTAR

    // BOTON IMPRIMIR
    
    $("#btnImprimir").click(function(){
        printGrid();
    });
    
    // FIN BOTON IMPRIMIR
       
      
     $('#btnLimpiar').click(function () {
       $('#cb_proyecto').data("kendoComboBox").text('');
       $('#cb_concepto').data("kendoComboBox").text('');
       $('#cb_caja').data("kendoComboBox").text('');
       $('#txt_fec_ini').val('');
       $('#txt_fec_fin').val('');
    });

});

    
      
   function castFecha(fecha){
        if(fecha === '')
            return '';
        var arrayfecha = fecha.split('-');
            fecha = arrayfecha[2] + arrayfecha[1] + arrayfecha[0];
        return fecha;
    }
</script>

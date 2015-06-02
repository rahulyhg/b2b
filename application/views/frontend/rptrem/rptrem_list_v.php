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
span.k-timepicker, span.k-datetimepicker, span.k-datepicker {width: auto;}
.k-grid-content{overflow-y: hidden;}
.k-grid-header{padding-right: 0px !important;}
.k-grid-footer{padding-right: 0px !important;}
.k-grid .k-group-col, .k-grid .k-hierarchy-col {width: 0.1px !important;}

</style>
<div id="main_container">
    <div class="row-fluid">   
         <div class="form-row row-fluid">
            <div>
                <label for="normal-field" class="control-label span2"><?= lang('asiento.new_title') ?></label>
            </div>
            <label for="normal-field" class="control-label span2"><?= lang('rptrem.rem_ini') ?></label>
            <div class="controls span3">
                <span class="row-fluid k-textbox">
                    <input  id="txt_rem_ini" name="txt_rem_ini" value="" />
                </span>
            </div>
            <label for="normal-field" class="control-label span2"><?= lang('rptrem.rem_fin') ?></label>
            <div class="controls span3">
                <span class="row-fluid k-textbox">
                    <input  id="txt_rem_fin" name="txt_rem_fin" value="" />
                </span>
            </div>
         </div>
        <br>
   <div class="form-row row-fluid">
       <a id="btnVer" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.view') ?></a>
       <a id="btnLimpiar" href="#" class="btn btn-secondary color_14" data-toggle="modal"><?= lang('boton.limp')?></a>
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
    </div>
</div>
    
    
</div>
<script type="text/javascript">
    
    var tituloInformacion = "<?= lang('g.titleMsgInfo')?>";
$(document).ready(function() {
     
     function printGrid() {
    var gridElement = $("#tbData"),
        win = window.open('', '', 'width= ' + screen.width + ' height= ' + screen.height + ', fullscreen'),
        doc = win.document.open(),
        htmlStart = 
            '<!DOCTYPE html>' +
            '<html>' +
            '<head>' +
            '<meta charset="utf-8" />' +
            '<title>Reporte por Numero de Remision</title>' + 
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
            '<body><div><center><b>REPORTE POR NUMERO DE REMISION ' + $("#txt_rem_ini").val() + ' - ' + $("#txt_rem_fin").val() +
            ' </b></center></div><center><br><br>',
                    htmlEnd = 
            '</center></body>' +
            '</html>';

            doc.write(htmlStart + '<br>' + gridElement.clone()[0].outerHTML +  htmlEnd);
            doc.close();
            win.print();
        }
         /****** inicio datasource **/
         var dataSource = new kendo.data.DataSource({
            transport: {
                read: { 
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('rptrem/get_rptrem_list') ?>",
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
//                        rendicion:      { type: "string" },
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
         var URL= "rptrem/load_reporte";
         

         if($("#txt_rem_ini").val() !== '' )
            URL = URL + "/" + $("#txt_rem_ini").val() ;
        else
            URL = URL + "/" + "SF" ;
        if($("#txt_rem_fin").val() !== '')
            URL = URL + "/"  + $("#txt_rem_fin").val();
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


//            },       
            pageable: false,
            columns: [
                { field: "TITULO",
                  hidden: true,
                  title: "Titulo agrupado: ",
                  groupHeaderTemplate: "#=value# (Nro. de Transacciones: #=count#) "
                },//titulo
                { field: "id_transaccion",
                  width: 60,
                  title: "<div style='font-size: 12px'>Id</div>",
                  attributes:{style:"font-size: 12px"}
                },
                { field: "fecha_sistema",
                  width: 75,
                  title: "<div style='font-size: 12px'>Fecha</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "CUENTA_DB",
                  width: 60,
                  title: "<div style='font-size: 12px; width: 58px;'>Cuenta_DB</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "CUENTA_CR",
                  width: 60,
                  title: "<div style='font-size: 12px; width: 57px'>Cuenta_CR</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "EMPRESA",
                  width: 55,
                  title: "<div style='font-size: 12px; width: 50px'>Empr.</div>",
                  attributes:{style:"font-size: 11px"} 
                },
                { field: "EMPRESA_DB",
                  width: 80,
                  title: "<div style='font-size: 12px; width: 77px'>Empr._DB</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "EMPRESA_CR",
                  width: 80,
                  title: "<div style='font-size: 12px; width: 76px'>Empr._CR</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "c_caja",
                  width: 100,
                  title: "<div style='font-size: 12px'>Caja</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "c_concepto",
                  width: 100,
                  title: "<div style='font-size: 12px'>Concepto</div>",
                  attributes:{style:"font-size: 11px"} 
                },
                { field: "c_sconcepto",
                  width: 100,
                  title: "<div style='font-size: 12px; width: 53px'>Subconcep.</div>",
                  attributes:{style:"font-size: 11px"}
                },
//                { field: "rendicion",
//                  //width: 20,
//                  title: "<div style='font-size: 12px'>Rendicion</div>",
//                  attributes:{style:"font-size: 11px"}
//                },
                { field: "observacion",
                  width: 150,
                  title: "<div style='font-size: 12px; width: 111px'>Observac.</div>" ,
                  attributes:{style:"font-size: 11px"},
                  footerTemplate: "Importe Total: ",
                  groupFooterTemplate: "Sub Total: "
                },
                { field: "IMPORTE", 
                  width: 80,
                  title: "<div style='font-size: 12px; width: 34px'>Importe_S/.</div>" ,
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  groupHeaderTemplate: "Valor: #=value# ",
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                  
                },
                { field: "IMPORTE_DOL",
                  width: 80,
                  title: "<div style='font-size: 12px; width: 32px'>Importe_$</div>",
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


 $("#btnExportar").click(function(e) {
     
     var data = $("#tbData").data("kendoGrid").dataSource.data();
     var result = "data:application/vnd.ms-excel,";
     
     result += "<table><tr><th>TITULO</th><th>id_transaccion</th><th>fecha_sistema</th><th>CUENTA_DB</th><th>CUENTA_CR</th><th>EMPRESA</th><th>EMPRESA_DB</th><th>EMPRESA_CR</th><th>c_caja</th><th>c_concepto</th><th>c_sconcepto</th><th>rendicion</th><th>observacion</th><th>IMPORTE</th><th>IMPORTE_DOL</th></tr>";
     
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

    // BOTON IMPRIMIR
    
    $("#btnImprimir").click(function(){
        printGrid();
    });    
    // FIN BOTON IMPRIMIR
    
     $('#btnLimpiar').click(function () {
       $('#txt_rem_ini').val('');
       $('#txt_rem_fin').val('');
    });

});
</script>

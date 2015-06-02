<?php
/*
 * Desarrollador    : Cesar Mamani Dominguez
 * Fecha Creación   : 2013.06.28
 * 
 * Desarrollador    : [Desarrollador]
 * Fecha Edición    : [yyyy.mm.dd]
 * 
 * Descripción      : Reporte Movimiento de saldo hehco integramente en kendo.
 */
?>
<style>

span.k-timepicker, span.k-datetimepicker, span.k-datepicker {
    width: auto;
}
</style>
<div id="main_container">
    <div class="row-fluid">
        <div class="form-row row-fluid">
             <label for="normal-field" class="control-label span2"><?= lang('rptconpre.selcaja') ?></label>
            <div class="controls span3">                
                <input id="cb_caja" name="cb_caja" class="row-fluid" />                   
            </div> 
        </div>
        <div class="form-row row-fluid">             
             <label for="normal-field" class="control-label span2"><?= lang('rptconpre.selproy') ?></label>
            <div class="controls span3">
                <input id="cb_proyecto" name="cb_proyecto" class="row-fluid" />           
            </div>
            <label for="normal-field" class="control-label span2"><?= lang('rptconpre.selconc') ?></label>
            <div class="controls span3">
                <input id="cb_concepto" name="cb_concepto" class="row-fluid" />           
            </div>
         </div>
                <div class="form-row row-fluid">
            <label for="normal-field" class="control-label span2"><?= lang('rptconpre.fch_ini') ?></label>
            <div class="controls span3">
                <input  id="txt_fec_ini" name="txt_fec_ini" value="" />
            </div>
            <label for="normal-field" class="control-label span2"><?= lang('rptconpre.fch_fin') ?></label>
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
            <!-- Div donde cargarán los fomularios -->
       </div>
       <br>
       <br>
       <div id="tbData">
       <!-- Div donde cargarán el reporte -->
       </div>
       <br>
    </div>
</div>

    
</div>
<script type="text/javascript">
    
    var tituloInformacion = "<?= lang('g.titleMsgInfo')?>";
$(document).ready(function() {

   var cb_subproyecto , cb_subconcepto, cb_caja ; 
   $.populateComboBox('#cb_caja', "<?= lang('rptconpre.selectall') ?>", 'Caja', 'c_codigo',<?php echo (isset ($jsonCajas)) ? $jsonCajas : 'null' ?>,1 );
   $.populateComboBox('#cb_proyecto', "<?= lang('rptconpre.selectall') ?>", 'Proyecto', 'id_proyecto',<?php echo (isset($jsonProyectos)) ? $jsonProyectos : 'null' ?>,1 );
   $.populateComboBox('#cb_concepto', "<?= lang('rptconpre.selectall') ?>", 'Concepto', 'id_concepto',<?php echo (isset ($jsonConceptos)) ? $jsonConceptos : 'null' ?>,1 );

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
            readOnly('txt_fec_ini');
            readOnly('txt_fec_fin');
 
     function printGrid() {
    var gridElement = $("#tbData"),
        win = window.open('', '', 'width= ' + screen.width + ' height= ' + screen.height + ', fullscreen'),
        doc = win.document.open(),
        htmlStart = 
            '<!DOCTYPE html>' +
            '<html>' +
            '<head>' +
            '<meta charset="utf-8" />' +
            '<title>Reporte de Control Inicial</title>' + 
            '<link href="http://cdn.kendostatic.com/' + kendo.version + '/styles/kendo.common.min.css" rel="stylesheet" media="print" /> '+
            '<style>' +
            'html { font: 11pt sans-serif; }' +
            'a:link {text-decoration:none;color:black;}' + 
            '.k-selectable{width: 100%;}' +
            '.k-header{border: solid 1px #000000;background-color: #D2D2D2;}'+
            '.k-grouping-row{border: solid 1px #000000;background-color: #B4B4B4;border-style: solid;border-color:#ff0000 #0000ff;}'+
            '.k-grid, .k-grid-content { height: auto !important; border: solid 1px #000000;}' +
            '.k-grid-toolbar, .k-grid-pager > .k-link { display: none; border: solid 1px #000000;}' +
            '.k-grid-header{padding-right: 47.1% !important;}'+ '.k-grid-footer{width: 100%;}'+
            '.k-group-footer{border: solid 1px #000000;background-color: #D2D2D2;}'+
            '.k-group-cell{border: solid 1px #000000;padding-left: 62px;width: 4%;}'+
            'td{border: solid 1px #000000;'+
            '</style>' +
            '</head>' + 
            '<body><div><center><b>REPORTE DE CONTROL INICIAL ' + $("#txt_fec_ini").val() + ' - ' + $("#txt_fec_fin").val() +
            ' </b></center></div><center><br><br>',
                    htmlEnd = 
            '</center></body>' +
            '</html>';

            doc.write(htmlStart + '<br>' + gridElement.clone()[0].outerHTML +  htmlEnd);
            doc.close();
            win.print();
        }
         var dataSource = new kendo.data.DataSource({
            transport: {
                read: { 
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('rptconpre/get_rptconpre_list') ?>",
                        success: 
                              function (resultado){
                               options.success(resultado);
                        }
                        ,
                        error   : function () {
                        console.log('ERROR?')
                        }
                }
            },
            error: function() {
                console.log('ERROR2');
            },
            pageSize: 0,
            schema: {
                model: {
                    id: "Codigo",
                    fields: {
                        id_transaccion: { type: "number" },
                        Codigo:         { type: "number" },
                        Fecha:          { type: "string" },
                        Caja:           { type: "string" },
                        C_Asignacion:      { type: "string" },
                        SC_Asignacion:      { type: "string" },
                        Concepto:        { type: "string" },
                        Subconcepto:         { type: "string" },
                        Empresa:     { type: "string" },
                        Cheque:    { type: "string" },
                        TIPO_CAMBIO:    { type: "number" },
                        IMPORTE:        { type: "number" },
                        IMPORTE_DOL:    { type: "number" }  
                    }
                }
            },
            aggregate: [
                        { field: "IMPORTE", aggregate: "sum" },
                        { field: "IMPORTE_DOL", aggregate: "sum" }]
});
   $('#btnVer').click(function (e){
        e.preventDefault();
        var cb_proyecto = $('#cb_proyecto').data("kendoComboBox");
        var cb_concepto = $('#cb_concepto').data("kendoComboBox");
        var cb_caja = $('#cb_caja').data("kendoComboBox");

         var URL= "rptconpre/load_reporte/";
         if(cb_proyecto.value() == "")
             URL = URL + "-1" + "/";
         else
             URL = URL + cb_proyecto.value() + "/";
         if(cb_concepto.value() =="")
             URL = URL + "-1" + "/";
         else
             URL = URL + cb_concepto.value()+ "/";
         if(cb_caja.value() =="")
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

            change: function() {
            var grid = $("#tbData").data("kendoGrid");
            if ( grid.dataItem(grid.select()) != undefined){
                var id = grid.dataItem(grid.select()).Codigo;
                var param = {id : id};
                $.openModal('#btnEdit', 'rptconpre/view_movimiento', '#dlgNew', param, "<?= lang('g.msgProcesing')?>");
            } else{
                jAlert('<?= lang('valid.select') ?>', 'Movimiento');
            }
            }, 
            pageable: false,
            
            columns: [
                { field: "Codigo",
                   width: 60,
                  title: "<div style='font-size: 12px; width: 59px;'>Codigo</div>",
                  attributes:{style:"font-size: 12px"}
                },
                { field: "Fecha",
                  width: 75,
                  title: "<div style='font-size: 12px; width: 74px;'>Fecha</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "Caja",
                  width: 150,
                  title: "<div style='font-size: 12px; width: 151px;'>Caja</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "C_Asignacion",
                  width: 150,
                  title: "<div style='font-size: 12px; width: 150px;'>C.Asignacion</div>",
                  attributes:{style:"font-size: 11px"}
                },
                { field: "SC_Asignacion",
                  width: 150,
                  title: "<div style='font-size: 12px; width: 152px;'>C.Asignacion</div>",
                  attributes:{style:"font-size: 11px"} 
                },
               { field: "Concepto",
                  width: 150,
                  title: "<div style='font-size: 12px; width: 151px;'>Concepto</div>",
                  attributes:{style:"font-size: 11px"} 
                },
                { field: "Subconcepto",
                  width: 150,
                  title: "<div style='font-size: 12px; width: 151px;'>Subconcepto</div>",
                  attributes:{style:"font-size: 12px"}
                },
                { field: "Empresa",
                  width: 80,
                  title: "<div style='font-size: 12px; width: 78px;'>Empresa</div>",
                  attributes:{style:"font-size: 12px"}
                },
                { field: "Cheque",
                  width: 80,
                  title: "<div style='font-size: 12px; width: 79px;'>Cheque</div>",
                  attributes:{style:"text-align:right; font-size: 12px"},
                  footerTemplate: "Importe ",
                  groupFooterTemplate: "Sub "
                },
                 
                 { field: "TIPO_CAMBIO",
                  width: 80,
                  title: "<div style='font-size: 12px; width: 79px;'>Tipo_Cambio</div>",
                  attributes:{style:"text-align:right; font-size: 12px"},
                  footerTemplate: "Total: ",
                  groupFooterTemplate: "Total: "
                },
                { field: "IMPORTE", 
                  width: 80,
                  title: "<div style='font-size: 12px; width: 78px;'>Importe_S/.</div>" ,
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
                  title: "<div style='font-size: 12px; width: 80px;'>Importe_$</div>",
                  format  : "{0:n2}",
                  decimals: 2, 
                  step    : 0.01,
                  attributes:{style:"text-align:right; font-size: 13px"},
                  footerTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#",
                  groupFooterTemplate: "<div style='float:right; font-size: 13px'>#=kendo.toString(sum,'n2','es-PE')#"
                  
                },
            ]
        });
    });

 $("#btnExportar").click(function(e) {
     
     var data = $("#tbData").data("kendoGrid").dataSource.data();
     var result = "data:application/vnd.ms-excel,";
     
     result += "<table><tr><th>Proyecto - Subproy.</th><th>Id</th><th>Fecha</th><th>Caja</th><th>Proyecto</th><th>Subproyecto</th><th>Concepto</th><th>Subconcepto</th><th>Empresa</th><th>Cheque</th><th>T. Cambio</th><th>Importe S/.</th><th>Importe US$</th></tr>";
     for (var i = 0; i < data.length; i++) {
         result += "<tr>";
         
         result += "<td>";
         result += data[i].Codigo;
         result += "</td>";
                  
         result += "<td>";
         result += kendo.format("{0:MM/dd/yyyy}", data[i].Fecha);
         result += "</td>";
         
         result += "<td>";
         result += data[i].Caja;
         result += "</td>";

         result += "<td>";
         result += data[i].C_Asignacion;
         result += "</td>";

         result += "<td>";
         result += data[i].SC_Asignacion;
         result += "</td>";

         result += "<td>";
         result += data[i].Concepto;
         result += "</td>";

         result += "<td>";
         result += data[i].SConcepto;
         result += "</td>";

         result += "<td>";
         result += data[i].Empresa;
         result += "</td>";
         
         result += "<td>";
         result += data[i].Cheque;
         result += "</td>";
         
         result += "<td>";
         result += data[i].T_Cambio;
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
       $('#cb_proyecto').data("kendoComboBox").text('');
       cb_subproyecto.text('');
       $('#cb_concepto').data("kendoComboBox").text('');
       cb_subconcepto.text('');
       $('#cb_caja').data("kendoComboBox").text('');
       cb_caja.text('');
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
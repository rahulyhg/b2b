
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

        <div class="row-fluid" >
            <div class="form-row control-group row-fluid ">    
                <label for="normal-field" class="control-label span1"><?= lang('rptproy.proy') ?></label>
                <div class="controls span3">
                    <input id="cb_proy" name="cb_caja" class="row-fluid" />                   
                </div>
                <label for="normal-field" class="control-label span1"><?= lang('rptproy.fch_ini') ?></label>
                <div class="controls span2">
                    <input  id="txt_fec_ini" name="txt_fec_ini" value="" />
                </div>
                <label for="normal-field" class="control-label span1"><?= lang('rptproy.fch_fin') ?></label>
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
      
        $('#txt_fec_ini').bind($.browser.msie ? 'click' : 'change', function(event) {
            setFiltros();
        })
        $('#txt_fec_fin').bind($.browser.msie ? 'click' : 'change', function(event) {
            setFiltros();
        })
        
        function setFiltros(){
             
             var URL= "reporteproy/update_filtros/";
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
                 URL = URL + $("#cb_proy").val() + "/"; 
             $.ajax({
                 type: "POST",
                 dataType: "html",
                 url:URL,

                 success: function(resultado){
                     console.log(resultado);

                 },
                 error: function(){
                     jAlert('<?= lang('rptcaja.exist')?>', tituloInformacion);
                 }

              });
        }
        
        $('#btnSearch').on('click', (function() {
            $('#tbData').data("kendoGrid").dataSource.read();
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
       
        $.saveModal('#frmNew', '#btnSearch', '#tbData', '#msgForm', "<?= lang('g.msgProcesing')?>");
        
        $.populateComboBox('#cb_proy', "", 'Proyecto', 'id_proyecto', <?php echo (isset($arrProy)) ? $arrProy : 'null' ?>, 1);
        $('#cb_caja').bind($.browser.msie ? 'click' : 'change', function(event) {
            setFiltros();
        })
        
        var dataSource = new kendo.data.DataSource({
            transport: {
                read:  function(options){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= site_url('reporteproy/get_saldos_list') ?>",
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
                        c_codigo:      { type: "string" },
                        c_proyecto:        { type: "string" },
                        SaldoDol:     { type: "number" },
                        SaldoSol:     { type: "number" }
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
                { field: "c_proyecto", width: 200, title: "Caja"},
                { field: "SaldoDol", width: 80, attributes:{style:"text-align:right;"}, title: "Saldo $", footerTemplate: "<div style='float: right'>Total: #=kendo.toString(sum,'n2','es-PE')#" },
                { field: "SaldoSol", width: 80,attributes:{style:"text-align:right;"}, title: "Saldo S/.", footerTemplate: "<div style='float: right'>Total: #=kendo.toString(sum,'n2','es-PE')#" }
            ]
        });
    });
</script>
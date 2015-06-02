<?php
/*
 * Desarrollador    : Jesús Rojas
 * Fecha Creación   : 2013.03.12
 * 
 * Desarrollador    : [Desarrollador]
 * Fecha Edición    : [yyyy.mm.dd]
 * 
 * Descripción      : CONTRATOS X VENCER
 */
?>
<style>
    #grid .k-toolbar
    {
        min-height: 27px;
    }
    .category-label
    {
        vertical-align: middle;
        padding-right: .5em;
        display: inline !important;
    }
    #category
    {
        vertical-align: middle;
    }
    .toolbar {
        float: left;
        margin-right: .8em;
    }
    div.divproceso{
        vertical-align: middle;
        padding-right: .5em;
        display: inline !important;
        color:#AD103C !important;
    }
    .k-grid-content{
        height: 400px !important
    }
</style>
<div class="box color_light">
    <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4> <i class="icon-book"></i>
            <span><?=lang('ctr.titleg')?></span> 
        </h4>
    </div>
    <div class="content">
        <div id="grid">
       </div>
    </div>
</div>
<script type="text/x-kendo-template" id="template">
    <div class="toolbar">
        <label class="category-label" for="category"><?= lang('ctr.sel2')?>:</label>
        <input type="search" id="category" style="width: 230px"></input>
        <div  id="divproceso" style="display: none"><?= lang('g.msgProcesing')?></div>
    </div>
</script>
<script type="text/javascript">
$(document).ready(function() {
        var ddlfiltros = <?php echo $jsonFiltros ?>, grid;
        fillkendogrid([]);
        var dropDown = grid.find("#category").kendoDropDownList({
            dataTextField: "DescripcionLargaTipo",
            dataValueField: "TipoId",
            optionLabel: "<?= lang('ctr.sel')?>",
            autoBind: false,
            dataSource: ddlfiltros,
            change: function() {
                if(this.value() !== ""){
                get_detalle_contratos(this.value(), function(result){
                    fillkendogrid(result);
                });    
                }else{
                    fillkendogrid([]);
                }
            }
        });
       
       function fillkendogrid(data){           
            grid = $("#grid").kendoGrid({
            dataSource: data,
            toolbar: kendo.template($("#template").html()),
            height: 450,
            sortable: true,
            pageable: false,
            selectable: "single",
            columns: [
                { field: "NumeroContrato", width: 100, title: "<?=lang('ctr.nroc')?>" },
                { field: "TipoDocumento", title: "<?=lang('ctr.tdoc')?>" },
                { field: "NumeroDocumento", title: "<?=lang('ctr.ndoc')?>"},
                { field: "Comentario", title: "<?=lang('ctr.come')?>" },
                { field: "FechaInicio", title: "<?=lang('ctr.bdat')?>" , format: "{0:dd-MMMM-yyyy}"},
                { field: "FechaFin", title: "<?=lang('ctr.edat')?>" , format: "{0:dd-MMMM-yyyy}"}
            ]
        });
    }
    
    function get_detalle_contratos(tipoID,callback)
    {
        $.ajax({
           type: "POST",   
           dataType: "json",
           url: "main/get_detalle_garantia",
           data: {tipoId : tipoID},
           beforeSend: function(){
               $('#divproceso').addClass('divproceso');
           },
           success: callback,
           error:function(){
                alert("error en la transacción");
                $('#divproceso').removeClass('divproceso');  
           },
           complete:function(){
               $('#divproceso').removeClass('divproceso');
           }

        });
    }
        
    });
</script>
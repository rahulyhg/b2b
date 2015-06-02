<?php

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
                <span><?=lang('ctr.titlepxc')?></span> 
            </h4>
    </div>
    <div class="content">    
        <div id="grid" style="height: 350px">
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
        var ddlfiltros = <?php echo $dataCriterio ?>;
        var jsonInicial = [{"ContratistaId": "0", "Descripcion":"", "NumeroContrato":"","NroPersonas":""}];
        var grid;
        fillkendogrid(jsonInicial);
        var dropDown = grid.find("#category").kendoDropDownList({
            dataTextField: "DescripcionLargaTipo",
            dataValueField: "TipoId",
            optionLabel: "<?= lang('ctr.sel')?>",
            autoBind: false,
            dataSource: ddlfiltros,
            change: function() {
                if(this.value() != ""){
                    get_detalle(this.value(), function(result){
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
            columns: [
                { field: "Descripcion", title:"<?=lang('ctr.ctrapxc')?>", width: "250px"
                },  
                { field: "NroPersonas", title:"<?=lang('ctr.nperpxc')?>", width: "100px"
                }
            ]
            });
        }
    
        function get_detalle(tipoID,callback)
        {
            $.ajax({
               type: "POST",   
               dataType: "json",
               url: "main/get_personas_x_contratista_list",
               data: {tipoId : tipoID},
               success: callback,
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
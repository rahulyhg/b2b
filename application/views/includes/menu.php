<?php 
 $arrSecMenu = $this->seguridad->sec_menu();

?>
<div id="loading"><img src="<?= site_url() ?>img/ajax-loader.gif"></div>
<div id="responsive_part">
    <div class="logo">
        <a href="<?= site_url() ?>index.html">
            <!--Mobile-->
            <span><?= lang('global.appname') ?></span><span class="icon"></span>
        </a>
    </div>
    <ul class="nav responsive">
        <li>
            <button class="btn responsive_menu icon_item" data-toggle="collapse" data-target=".overview"> <i class="icon-reorder"></i> </button>
        </li>
    </ul>
</div>
<!-- Responsive part -->

<div id="sidebar" class="">
    <div class="scrollbar">
        <div class="track">
            <div class="thumb">
                <div class="end"></div>
            </div>
        </div>
    </div>
    <div class="viewport">
        <div class="overview collapse">
            <div class="search row-fluid container">
                <center>
                <h2 style="font-size: 4.3rem; "> <?= lang('global.appname') ?> 
                   
                </h2>
                
<!--                <form class="form-search">
                    <div class="input-append">
                        <input type="text" class=" search-query" placeholder="">
                        <button class="btn_search color_14">Lanzador</button>
                    </div>
                </form>-->
              </center>
            </div>
            <ul id="sidebar_menu" class="navbar nav nav-list container full">
               <?php if (in_array('m_dsk', $arrSecMenu)) {?>
                <li class="accordion-group <?php if (isset($mGroup) && ($mGroup == 'm_dsk')) echo ' active ';?> color_14">
                    <a class="dashboard " href="<?= site_url('main') ?>">
                        <img src="<?= site_url() ?>img/menu_icons/dashboard.png"><span><?= lang('menu.m_dsk') ?></span>
                    </a>
                </li>
                <?php } if (in_array('m_conf', $arrSecMenu)) {?>
                <li class="accordion-group <?php if (isset($mGroup) && ($mGroup == 'm_conf')) echo ' active ';?> color_14">
                    <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse1">
                        <img src="<?= site_url() ?>img/menu_icons/grid.png"><span><?= lang('menu.m_conf') ?></span>
                    </a>
                    <ul id="collapse1" class="accordion-body collapse <?php if (isset($mGroup) && ($mGroup == 'm_conf')) echo ' in ';?>">
                        <?php if (in_array('m_conf_01', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_01')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('empresa') ?>"><?= lang('submenu.m_conf_01') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_02', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_02')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('proyecto') ?>"><?= lang('submenu.m_conf_02') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_03', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_03')) echo ' active '; ?>" >
                            <a target="_blank" href="<?= site_url('subproyecto') ?>"><?= lang('submenu.m_conf_03') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_04', $arrSecMenu)) {?>
                        <li class=" <?php if (isset($mOption) && ($mOption == 'm_conf_04')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('concepto') ?>"><?= lang('submenu.m_conf_04') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_05', $arrSecMenu)) {?>
                        <li class=" <?php if (isset($mOption) && ($mOption == 'm_conf_05')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('subconcepto') ?>"><?= lang('submenu.m_conf_05') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_06', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_06')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('ctacontable') ?>"><?= lang('submenu.m_conf_06') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_07', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_07')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('cuentadc') ?>"><?= lang('submenu.m_conf_07') ?></a>
                        </li>  
                        <?php } if (in_array('m_conf_08', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_08')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('caja') ?>"><?= lang('submenu.m_conf_08') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_09', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_09')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('tipo') ?>"><?= lang('submenu.m_conf_09') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_10', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_10')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('usuario') ?>"><?= lang('submenu.m_conf_10') ?></a>
                        </li>
                        <?php } if (in_array('m_conf_11', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_conf_11')) echo ' active ';?>" >
                            <a target="_blank" href="<?= site_url('perfil') ?>"><?= lang('submenu.m_conf_11') ?></a>
                        </li>
                        </li>
                        <?php }?>
                    </ul>
                </li>
                <?php } if (in_array('m_datos', $arrSecMenu)) {?>
                <li class="accordion-group <?php if (isset($mGroup) && ($mGroup == 'm_datos')) echo ' active ';?> color_14">
                    <a class="accordion-toggle widgets collapsed " data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse2">
                        <img src="<?= site_url() ?>img/menu_icons/forms.png"><span><?= lang('menu.m_datos') ?></span>
                    </a>
                    <ul id="collapse2" class="accordion-body collapse <?php if (isset($mGroup) && ($mGroup == 'm_datos')) echo ' in ';?>">
                        <?php if (in_array('m_datos_01', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_datos_01')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('transaccion') ?>"><?= lang('submenu.m_datos_01') ?></a>
                        </li>
                        <?php }?>
                        <?php if (in_array('m_datos_02', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_datos_02')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('asiento') ?>"><?= lang('submenu.m_datos_02') ?></a>
                        </li>
                        <?php }?>
                    </ul>
                </li>
                <?php } if (in_array('m_consultas', $arrSecMenu)) {?>
                <li class="accordion-group <?php if (isset($mGroup) && ($mGroup == 'm_consultas')) echo ' active ';?> color_14">
                    <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse3">
                        <img src="<?= site_url() ?>img/menu_icons/widgets.png"><span><?= lang('menu.m_consultas') ?></span>
                    </a>
                    <ul id="collapse3" class="accordion-body collapse <?php if (isset($mGroup) && ($mGroup == 'm_consultas')) echo ' in ';?>">
                        <?php if (in_array('m_consultas_01', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_01')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('reportemov') ?>"><?= lang('submenu.m_consultas_01') ?></a>
                        </li>
                        <?php } ?>
                    
                        <?php if (in_array('m_consultas_02', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_02')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('rptmovreg') ?>"><?= lang('submenu.m_consultas_02') ?></a>
                        </li>
                        <?php } ?>
                    
                        <?php if (in_array('m_consultas_03', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_03')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('reportecaja') ?>"><?= lang('submenu.m_consultas_03') ?></a>
                        </li>
                        <?php } ?>
                    
                        <?php if (in_array('m_consultas_04', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_04')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('reporteproy') ?>"><?= lang('submenu.m_consultas_04') ?></a>
                        </li>
                        <?php } ?>
                    
                        <?php if (in_array('m_consultas_05', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_05')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('rptctacaja') ?>"><?= lang('submenu.m_consultas_05') ?></a>
                        </li>
                        <?php } ?>
                    
                        <?php if (in_array('m_consultas_06', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_06')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('rptcajaemp') ?>"><?= lang('submenu.m_consultas_06') ?></a>
                        </li>
                        <?php } ?>
                        
                       <?php if (in_array('m_consultas_07', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_07')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('rptconpre') ?>"><?= lang('submenu.m_consultas_07') ?></a>
                        </li>
                        <?php } ?>
                        
                         <?php if (in_array('m_consultas_08', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_08')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('rptrem') ?>"><?= lang('submenu.m_consultas_08') ?></a>
                        </li>
                        <?php } ?>
                        
                       <?php if (in_array('m_consultas_09', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_09')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('rptsaldosxmes') ?>"><?= lang('submenu.m_consultas_09') ?></a>
                        </li>
                        <?php } ?>
                        
                       <?php if (in_array('m_consultas_10', $arrSecMenu)) {?>
                        <li class="<?php if (isset($mOption) && ($mOption == 'm_consultas_10')) echo ' active ';?>">
                            <a target="_blank" href="<?= site_url('repmovdc') ?>"><?= lang('submenu.m_consultas_10') ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    
                 </li>
                <?php }  ?>
            </ul>
            <div class="menu_states row-fluid container ">
                <h2 class="pull-left"><?= lang('cnfg.title')?></h2>
                <div class="options pull-right">
                    <button id="menu_state_1" class="color_14" rel="tooltip" data-state ="sidebar_icons" data-placement="top" data-original-title="Menu Iconos">1</button>
                    <button id="menu_state_2" class="color_14 active" rel="tooltip" data-state="sidebar_default" data-placement="top" data-original-title="Menu Fijo">2</button>
                    <button id="menu_state_3" class="color_14" rel="tooltip" data-placement="top" data-state ="sidebar_hover" data-original-title="Menu Flotante">3</button>
                </div>
            </div>
            <!-- End sidebar_box --> 
        </div>
    </div>
</div>

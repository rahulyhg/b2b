<!DOCTYPE html>
<html class="sidebar_default no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <!-- COMPATIBILIDAD CON INTERNET EXPLORER DESDE HTML -->
        <!-- <meta http-equiv=”X-UA-Compatible” content=”IE=edge”/>-->
        
        <title><?= lang('global.appname') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?= site_url() ?>css/images/favicon.png">
        
        <!-- KendoUI -->
        <link href="<?= site_url() ?>kui/styles/kendo.common.min.css" rel="stylesheet">
        <link href="<?= site_url() ?>kui/styles/kendo.default.min.css" rel="stylesheet">
        <!-- End KendoUI -->
        <!-- App Requisitos -->
        <link href="<?= site_url() ?>css/twitter/responsive.css" rel="stylesheet">  
        <link href="<?= site_url() ?>css/apprequisitos.min.css" rel="stylesheet">
        <!-- End App Requisitos -->
       <script src="<?= site_url() ?>js/plugins/modernizr.js"></script>
         Grilla 
  <!--      <link rel="stylesheet" type="text/css" media="screen" href="<?= site_url() ?>lib/js/themes/flick/jquery-ui.custom.min.css"></link>	
        <link rel="stylesheet" type="text/css" media="screen" href="<?= site_url() ?>lib/js/jqgrid/css/ui.jqgrid.min.css"></link>-->

        <script src="<?= site_url() ?>kui/js/jquery.min.js"></script>
        <script type="text/javascript">
            var gs_idioma = '<?= lang('global.lang_key') ?>';
            if (gs_idioma == ''){
                gs_idioma = 'en';
            } 
        </script>

    </head>
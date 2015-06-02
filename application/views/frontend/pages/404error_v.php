<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Page-Enter" content="blendTrans(Duration=0.2)">
        <meta http-equiv="Page-Exit" content="blendTrans(Duration=0.2)">
        <title>404 - Requisitos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?= site_url() ?>css/images/favicon.png">
        <!-- Estilos -->
        <link href="<?= site_url() ?>css/base.css" rel="stylesheet">
        <link href="<?= site_url() ?>css/avgrund.css" rel="stylesheet">
        <link href="<?= site_url() ?>css/colorpicker.css" rel="stylesheet">
        <link href="<?= site_url() ?>css/twitter/responsive.css" rel="stylesheet">


        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->
    </head>
    <body>

        <!-- Login page -->
        <div id="error404" class="other_pages">
            <div class="row-fluid container spacer fluid">

                <div class="span12">
                    <h2><?= lang('global.404title1') ?>
                        </h3>
                        <h1>
                            <?= lang('global.404title2') ?></h2>
<!--                    <h3 class="bottom-line"><?= lang('global.404title3') ?></h3>-->
                </div>
            </div>
            <!-- End .container -->
            <div class="row-fluid  fluid ">
<!--                <div class="container box paint_hover row-fluid">
                    <div class="row-fluid fluid">
                        <div class="input-append span8 search_field">
                            <input class="row-fluid" id="prependedInput" size="16" type="text" placeholder="<?= lang('global.404title4') ?>">
                            <span class="add-on btn"><?= lang('global.404title5') ?></span> </div>-->
                        <div class="span4"> <a href="<?= site_url('main') ?>" class="btn btn-primary inline row-fluid"><?= lang('global.404title6') ?></a> </div>
<!--                    </div>
                </div>-->
            </div>
            <!-- End #error404 --> 
        </div>

        <!-- Le javascript================================================== --> 
        <script src="<?= site_url() ?>js/jquery.js"></script>

    </body>
</html>


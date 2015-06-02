<?php ?>
<!DOCTYPE html>
<html class="no-js login" lang="en">
    <head>
        <meta charset="utf-8">
        <title><?= lang('global.appname') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Requisitos">
        <meta name="author" content="Adexus Apps">
        <link rel="shortcut icon" href="<?= site_url() ?>css/images/favicon.png">

        <!-- Estilos -->
        <link href="<?= site_url() ?>css/base.css" rel="stylesheet">
       <link href="<?= site_url() ?>css/avgrund.css" rel="stylesheet">
        <link href="<?= site_url() ?>css/colorpicker.css" rel="stylesheet">
        <link href="<?= site_url() ?>css/twitter/responsive.css" rel="stylesheet">
        <style>
            #login_page {
                height: 100%;
                left: 0%;
                top: 0%;
                width: 100%;
            }
            .hdr{
                z-index: 9999;
            }
            .xpading{
                padding-top: 0px;
                text-align: center;
                color: #ee5f5b;
                font-weight: bold;
            }
            .mrgn_lgn{
                margin-bottom:50%;
            }
            html input[type="text"], html input[type="password"], html input[type="datetime"], html input[type="datetime-local"], html input[type="date"], html input[type="month"], html input[type="time"], html input[type="week"], html input[type="number"], html input[type="email"], html input[type="url"], html input[type="search"], html input[type="tel"], html input[type="color"], html .uneditable-input {
                height: 32px;
                padding: 0.1em 0;
            }
            footer{
                height: 80%;
                padding-bottom:  200px;
            }
            .row-fluid.fluid.ftr_lgn{
                position: fixed;
                color: #FFFFFF;
                font-size: 100%;
                width: 200%;
                float: right;
            }
            .navbar {
                color: #FFFFFF;
            }
            
            #login img {
                box-shadow: none;
                position: relative;
            }
            
            * {
                -moz-box-sizing: none;
            }
        </style>
        <!-- Script -->
        <!-- <script src="js/plugins/modernizr.custom.32549.js"></script> -->

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
              <![endif]-->
    </head>

    <body>
        <!-- HEADER -->
        <div class="header row-fluid">
           <div class="span10"></div>
           <div class="span2">
            <div class="top_left " >
                
                <div class="btn-group inline hdr">
                    <a style="margin-right: 4px" href="<?= site_url('es/login')?>"><img width="32px" height="32px" src="<?= site_url() ?>img/flag_spain.png"></a>
                    <a  href="<?= site_url('en/login')?>"><img width="32px" height="32px" src="<?= site_url() ?>img/flag_eeuu.png"></a>
                </div>
                
            </div>
            </div>
        </div>
        <!-- END HEADER -->
        <div class="row-fluid">
            <div id="login_page"> 
                <!-- Login page -->
                <div id="login">
                     
                    <div class="row-fluid fluid mrgn_lgn" >
                        <div class="span5">
                            <img src="<?= site_url() ?>img/caja03.jpg"> 
                        </div>
                        <div class="span7">
                            <div class="title">
                                <span class="name"><?=lang('login.title')?></span>
                            </div>
                                
                            <div style="padding-top: 50px;" class="content ">
<!--                                <form id="formlogin" action="<?= site_url('login/isValid') ?>" method="POST" class="form-horizontal row-fluid">-->
                                    <?php echo form_open('login/isValid', array('id' => 'formlogin', 'class' => 'bs-docs-example form-horizontal')); ?>
                                    <div class="control-group row-fluid">
                                        <div class="controls span9 input-append">
                                            <input type="text" tabindex="1" id="txtUsername" name="txtUsername" placeholder="<?= lang('global.user') ?>" class="row-fluid" value="<?= set_value('txtUsername') ?>">
                                            <span class="add-on"><i class="icon-user"></i></span>
                                        </div>
                                    </div>
                                    <div class="control-group row-fluid">
                                        <div class="controls span9 input-append">
                                            <input type="password" tabindex="2" id="txtPassword" name="txtPassword" placeholder="<?= lang('global.pass') ?>" class="row-fluid">
                                            <span class="add-on"><i class="icon-lock"></i></span>
                                        </div>
                                    </div>
                                    <div class="control-group row-fluid">
                                        <div class="controls span8">
                                            <button type="submit" class="btn btn-primary color_0"><?= lang('global.singin') ?></button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
<!--                                </form>-->
                            </div>
                        </div>
                        <div class="content xpading">
                            <?php if (isset($sMsgError)) echo $sMsgError; ?>
                        </div>
<!--                        <div id="msgForm" class="content xpading"></div>-->
                    </div>
                    <div class="navbar navbar-fixed-bottom">
                        <div class="footer row-fluid ftr_lgn">
                            <p><?= lang('login.footer') ?><p>	
                        </div>
                     </div>
                
                </div>
                <!-- End #login -->
            </div>
        </div>

        <!-- End #loading --> 
        <!-- JavaScript --> 
        <script type="text/javascript" src="<?= site_url('kui/js/jquery.min.js') ?>"></script> 
        <!--<script src="js/bootstrap-dropdown.js" type="text/javascript"></script>--> 
        <script type='text/javascript'> 
            
//            var tituloInformacion = "<?= lang('g.titleMsgInfo')?>";
            
            $(window).load(function() {
                
                $('#txtUsername').focus();
                
//                $('#formlogin').submit(function(event) {  
//                    event.preventDefault(); 
//     
//                    $.ajax({
//                        type: "POST",   
//                        dataType: "html",
//                        url: "login/isValid",
//                        data: {txtUsername : $("#txtUsername").val(),
//                               txtPassword : $("#txtPassword").val()},
//                        success: function(resultado){
//                            alert(resultado.length);
//                            if(resultado.length < 200){
//                                $('#msgForm').html(resultado);
//                            }
//                            else
//                            {
//                                window.location = "main";
//                            }
//                        },
//                        error: function(){
//                             alert('<?= lang('rqmnt.err') ?>');
//                        }
//                    });  
//                 });
                
            });
        </script>
    </body>
    

</html>

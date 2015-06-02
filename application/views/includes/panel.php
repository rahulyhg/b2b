<style>
#mpassword {
        left: 50% !important;
        width: 50% !important;
        background-color: #E5E5E5 !important;
        height: 60% !important;
    }
</style>
<div id="main">
    <div class="container">
        <div class="header row-fluid">
            <div class="logo">
                <a href="<?= site_url() ?>"><span><?php if (isset($title)) echo $title; ?></span><span class="icon"></span></a> 
            </div>
            <div class="top_right">
                <ul class="nav nav_menu">
                    <li class="dropdown"> 
                        <a class="dropdown-toggle administrator" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="../../page.html">
                            <div class="title">
                                <span class="name"><?php if (isset($userName)) echo $userName; else echo '[User]'; ?></span>
                                <span class="subtitle"><?php if (isset($contractor)) echo $contractor; else echo '[Contractor]'; ?></span>
                            </div>
                            <span class="icon"><img src="<?= site_url() ?>img/usuario72.png" width="73" height="73"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?= site_url() ?>profile"><i class=" icon-user"></i> Mi Perfil</a></li>
                            <li><a href="<?= site_url() ?>setting"><i class=" icon-cog"></i> Configuración</a></li>
                            <li><a href="<?= site_url() ?>helpt"><i class=" icon-flag"></i> Ayuda</a></li>
                            <li><a id="changepass" onclick="cambiarpassword()" href="javascript:void(0);"><i class="icon-key"></i> Cambiar Contraseña</a></li>                            
                            <li><a  href="main/logout"><i class=" icon-unlock"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- End top-right --> 
        </div> 
        
<div id="mpassword" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<script type="text/javascript"> 
    function cambiarpassword(){
            $.openModal('#changepass', 'usuario/cambiar_contrasenia', '#mpassword', "<?= lang('g.msgProcesing')?>");

    }
</script>



    
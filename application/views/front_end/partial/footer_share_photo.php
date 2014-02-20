<div data-role="header" data-theme="a">
    <div data-role="navbar" data-theme="a" >
        <ul>
            <?php if(!isset($no_back)) { ?>
            <li title="Regresa una Página"><a href="javascript:history.go(-1)" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false"><img src="<?php echo base_url();?>images/regresar.png" width="32" height="32" alt="Visit our Twitter Feed"><br />REGRESAR</a></li>
            <?php }  ?>
            <li title="Hazte Fan"><a href="https://www.facebook.com/ecuadorinmobilee?fref=ts" target="_blank" data-show-count="false" data-show-screen-name="false"><img src="<?php echo base_url();?>images/white_facebook.png" width="32" height="32" alt="Follow Us on Facebook"><br />HAZTE FAN</a>
                </li>
            <li title="Síguenos en Twitter"><a href="https://twitter.com/ecuadorinmobile" target="_blank" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false"><img src="<?php echo base_url();?>images/white_twitter_bird.png" width="32" height="32" alt="Visit our Twitter Feed"><br />SÍGUENOS EN TWITTER</a></li>

            <li title="Ver galería"><a href="#<?php echo $id?>" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false"><img src="<?php echo base_url();?>images/foto.png" width="32" height="32" alt="Visit our Twitter Feed"><br />
                    FOTOS</a></li>
        </ul>
    </div>
    <p class="copyright">&copy; 2012 Rutas moviles.com &nbsp;&nbsp;</p>
</div>
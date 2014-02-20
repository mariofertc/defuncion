<div data-role="content" data-theme="d" class="laciudad2" >
    <h1>UNIDAD DE TURISMO</h1>
    <p>Encuentranos en:</p>
        <!-- Address and Phone -->
    <ul data-role="listview" data-theme="a" data-inset="true" class="icab">
        <li ><img src="<?php echo base_url()?>images/pin.png" alt="Location" class="ui-li-icon">Halflants entre Ambato y Rocafuerte</li>
        <li style="background:#FFBF00">
            <a href="tel:0983819961"><img src="<?php echo base_url()?>images/fono.png" alt="Phone" class="ui-li-icon">Teléfono:
            0983819961
            </a>
        </li>
        <li><img src="<?php echo base_url()?>images/email.png" alt="Phone" class="ui-li-icon">Email:
            info@banos-ecuador.com</li>
    </ul>
    <div data-role="content" class="content" data-theme="d" style="margin-top:15px">
        <form action='mobil/send_email' data-ajax="false">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="" placeholder="Escribe aquí tu nombre" />
            <br />
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="" placeholder="correo@dominio.(com,es,etc.)" />
            <br />
            <label for="textarea">Mensaje:</label>
            <textarea name="mensaje" id="mensaje" placeholder="Escribe tu mensaje"></textarea>
            <br />
            <input type='submit' data-rel="dialog" data-transition="pop" data-role="button" data-inline="true" data-theme="a" value='Send'/>
            <a href="#aboutus" data-role="button" data-inline="true" data-theme="a">Reset </a>
        </form>
    </div>
    <!-- END OF: Address and Phone -->
</div>
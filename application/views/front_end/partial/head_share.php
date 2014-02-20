<div data-role="header" data-theme="a" class="yellow">
   <div class="bannerr"></div>
		<div data-role="navbar" data-theme="e" class="pie">
            <ul>
                <li title="inicio"><a href="#home" data-transition="slideup" data-icon="home" id="home_button">Inicio</a></li>
                <li title="Categorias"><a href="#oferta" data-icon="grid" id="oferta_button">Categorias</a></li>
                <li title="Contáctanos" ><a href="#aboutus" data-icon="info" id="aboutus_button">Contáctanos</a></li>
                <li title="ubicación"><a href="#geo" data-icon="phone-touch" id="geo_button" onclick="sessionStorage.categoria_id=<?php echo isset($oferta->id)?$oferta->id:(isset($lugar->categoria_id)?$lugar->categoria_id:0);?>;sessionStorage.lugar_id=<?php echo isset($lugar->id)?$lugar->id:0;?>">Ubicación</a></li>
            </ul>
        </div>
</div>
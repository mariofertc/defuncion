<div data-role="header" data-theme="a" class="yellow">
		<div data-role="navbar" data-theme="e" class="pie">
            <ul>
                <li title="inicio"><a href="#home" class="ui-btn-active"data-transition="slideup" data-icon="home">Inicio</a></li>
                <li title="Categorias"><a href="#oferta" data-transition="slideup" data-icon="grid">Categorias</a></li>
                <li title="Contáctanos" ><a href="#aboutus" data-transition="slideup" data-icon="info">Contáctanos</a></li>
                <li title="ubicación"><a href="#geo" data-transition="slideup" data-icon="phone-touch"  onclick="sessionStorage.categoria_id=<?php echo isset($oferta->id)?$oferta->id:(isset($lugar->categoria_id)?$lugar->categoria_id:0);?>;sessionStorage.lugar_id=<?php echo isset($lugar->id)?$lugar->id:0;?>">Ubicación</a></li>
            </ul>
        </div>
</div>

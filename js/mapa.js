$(window).load(function() {
    $('.flexslider').flexslider();
});
sessionStorage.lugar_id = 0;
sessionStorage.categoria_id = 0;
//cambia combos
$(document).on('click', '#search_map', function() {
    sessionStorage.categoria_id = $('#oferta_select').val();
    sessionStorage.lugar_id = $('#lugar_select').val();
    geolocalizar();
});
var mapa;
var infowindow = new google.maps.InfoWindow({maxWidth: 320});
var obj = new Object();
var bounds = new google.maps.LatLngBounds();

function setChinche() {

}

function cargar(datos) {
    $.ajax({
        url: 'mobil/coordenadas',
        data: {categoria_id: sessionStorage.categoria_id,
            lugar_id: sessionStorage.lugar_id},
        type: "GET",
        success: function(coord) {
            var lat = datos.coords.latitude;
            var lon = datos.coords.longitude;
            //Cruz de Bellavista -- Referencia a Baños
            var latlng_banos = new google.maps.LatLng(-1.398773, -78.414838);
            obj.latlng_current = new google.maps.LatLng(lat, lon);
            var esGeo = false;
            if ($.mobile.activePage.attr("id") == "geo")
                esGeo = true;
            if (esGeo)
                bounds.extend(obj.latlng_current);
//            $("#status").text("");
            /*$("#mapa").css("height", 480).css("margin", "0 auto").css("width", 320);*/
            var opcionesMapa = {center: obj.latlng_current,
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            if (esGeo) {
                mapa = new google.maps.Map(document.getElementById("mapa"), opcionesMapa);
                var opcionesChinche = {
                    position: obj.latlng_current,
                    map: mapa
                };
                var chinche = new google.maps.Marker(opcionesChinche);
                chinche.setMap(mapa);
                google.maps.event.addListener(chinche, "click", function() {
                    infowindow.setContent("<div id='hook' class = 'info_mapa'><h3>Te encuentras aqui!</h3><p>Distancia a Baños es: " + (distance) + " km </p></div>");
                    infowindow.open(mapa, chinche);
                });
            }
            //Carga de los Lugares.
            obj.indice_lugar = 0;
            $('#sitios_mapa').html("");
            $.each($.parseJSON(coord), function() {
                if (this.length >= 1) {
                    $.each(this, function() {
                        if (this != undefined && this.latitud != undefined)
                        {
                            if (sessionStorage.categoria_id == this.id_categoria && $('#oferta_select').val() != this.id_categoria && esGeo)
                            {
                                $('#oferta_select').val(this.id_categoria).trigger('change');
                                $('select#oferta_select').selectmenu('refresh');
                            }
                            obj.latlng_lugares = new google.maps.LatLng(this.latitud, this.longitud);
                            if (obj.indice_lugar < 5 && esGeo)
                                bounds.extend(obj.latlng_lugares);
                            obj.distance_sitio = (google.maps.geometry.spherical.computeDistanceBetween(obj.latlng_current, obj.latlng_lugares) / 1000).toFixed(2);
                            var arrive_time = (obj.distance_sitio / 90).toFixed(2);
                            obj.titulo = this.titulo;
                            obj.coordenada = this.latitud + " - " + this.longitud;
                            //Actualiza sitio contenido
                            $('#distancia_' + this.id_lugar).html(obj.distance_sitio + " Km");
                            $('#distancia2_' + this.id_lugar).html(obj.distance_sitio + " Km");
                            $('#tiempo_' + this.id_lugar).html(arrive_time + " Horas");

                            if ((sessionStorage.lugar_id == this.id_lugar || sessionStorage.lugar_id == 0) && esGeo)
                            {
                                obj.indice_lugar++;
                                obj.icono = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' + obj.indice_lugar + '|0055FF|ffffff';
                                var opcionesOjos = {
                                    position: obj.latlng_lugares,
                                    map: mapa,
                                    //icon: 'http://www.googlemapsmarkers.com/v1/'+ indice_lugar + '/0099FF',
                                    icon: obj.icono,
                                    title: obj.titulo,
                                    draggable: true
                                };
                                var chinche = new google.maps.Marker(opcionesOjos);
                                chinche.setMap(mapa);
                                var distancia = obj.distance_sitio;
                                var titulo = obj.titulo;
                                var coordenada = obj.coordenada;
                                google.maps.event.addListener(chinche, "click", function() {
                                    infowindow.setContent("<div id='hook' class='info_mapa'><h3>"
                                            + titulo +
                                            "</h3><p>Distancia al lugar es: " + distancia + " km </p>" +
                                            "<p>Coordenadas: " + coordenada + " </p></div>");
                                    infowindow.open(mapa, chinche);
                                });
//                                setChinche();
                                //Actualiza el listado de sitios
                                $("#sitios_mapa").append('<li><img src=' + obj.icono + ' class="ui-li-thumb ui-corner-tr" style="z-index:100; padding:5px 5px">' + $('#distancia_' + this.id_lugar).parent().parent().clone().html() + '</li>');
                                if (sessionStorage.lugar_id === this.id_lugar) {
                                    $('select#lugar_select option[value=' + this.id_lugar + ']').attr('selected', 'selected');
                                    $('select#lugar_select').selectmenu('refresh');
                                    //Get route
                                    getRoute(obj);
                                }
                            }
                        }//Fin del If
                    });
                }
            });
            if (esGeo) {
                //Añadir estilos al infoWindow.
                google.maps.event.addListener(infowindow, "domready", function() {
                    $('#hook').parent().parent().parent().siblings().addClass("info_mapa");
                });
                //Add lazy load to cloned images.
                $("img.lazy").show().lazyload();
                google.maps.event.addListenerOnce(mapa, 'idle', function() {
                    mapa.fitBounds(bounds);
                });
//            mapa.fitBounds(bounds);
//            mapa.panToBounds(bounds);
                //Refresh Style
                if ($('#sitios_mapa').hasClass('ui-listview')) {
                    $('#sitios_mapa').listview('refresh');
                }
            }
            distance = (google.maps.geometry.spherical.computeDistanceBetween(obj.latlng_current, latlng_banos) / 1000).toFixed(2);
        }
    }); //Fin del Ajax call           
}

function getRoute(obj) {
    var directionsService = new google.maps.DirectionsService();
    var directionsRequest = {
        origin: obj.latlng_current,
        destination: obj.latlng_lugares,
        travelMode: google.maps.DirectionsTravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC
    };
    directionsService.route(
            directionsRequest,
            function(response, status)
            {
                if (status == google.maps.DirectionsStatus.OK)
                {
                    new google.maps.DirectionsRenderer({
                        map: mapa,
                        directions: response
                    });
                }
                else
                    $("#error").append("Unable to retrieve your route<br />");
            }
    );
}
//$(document).on('pageinit', '#geo', function() {


//$('#geo').live('pageshow', function(event, ui) {
$(document).on('pageshow', '#geo', function() {
    geolocalizar();
});

var id_evento;
function geolocalizar()
{
    //navigator.geolocation.getCurrentPosition(cargar,errorMapa,{'enableHighAccuracy':false,'timeout':10000,'maximumAge':20000});
    if (Modernizr.geolocation) {
        if (id_evento != null)
        {
            navigator.geolocation.clearWatch(id_evento);
            id_evento = null;
        }
        id_evento = navigator.geolocation.watchPosition(cargar, errorMapa, {maximumAge: Infinity, timeout: 50000, enableHighAccuracy: true});
        $("#status").text("En tu busqueda ....");
//        navigator.geolocation.getCurrentPosition(showMap)
    } else {
        //no support, provide a fallback. Maybe
    }
}
function errorMapa()
{
    $("#status").text("Tarde o temprano te encontrare");
}
//$(document).bind("mobileinit", function(){
$(document).ready(function() {
    geolocalizar();
});
//            function change_page(page_name) {
//                $.mobile.changePage($('#' + page_name));
//            }
//            $('#geo').live('pagecreate', function (event, ui) {
//              $('#geo').live('pagebeforeshow', function (event, ui) {
//              $('#geo').live('pageinit', function (event, ui) {
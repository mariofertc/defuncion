<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gps {

    public $CI;

    public function __construct() {
        $this->CI = & get_instance();
        // Do something with $params
    }

    public function get_lugares_distancia($id_oferta) {
        $lugares = $this->CI->Lugar->get_by_categoria($id_oferta);
//        echo "<script>coordenadas_current</script>";
        return $lugares;
//        foreach ($lugares->result() as $lugar) {
//            $coordenadas = json_decode($lugar->coordenadas);
//            echo "<script></script>";
//            echo "<script>navigator.geolocation.getCurrentPosition(cargar,errorMapa);</script>";
//            echo "<script>latlng_lugares = new google.maps.LatLng("+ $coordenadas->latitud +  "," + $coordenadas->longitud + " this.longitud)</script>";
//            var latlng_lugares = new google.maps.LatLng(this.latitud , this.longitud);
//            var distance_sitio = (google.maps.geometry.spherical.computeDistanceBetween(latlng_current, latlng_lugares)/1000).toFixed(2);
//        };
    }

}

/* End of file gpsClass.php */
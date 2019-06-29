<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Yandex geocode locations
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   library
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
class Location {
    /**
     * Send query (lat & lon) to yandex geocode service
     * @param float $latitude
     * @param float $longitude
     * @return string
     */
    function get_address($latitude, $longitude) {
        $geocode = @file_get_contents('http://geocode-maps.yandex.ru/1.x/?geocode=' . $latitude . ',' . $longitude . '&sco=latlong&results=1');

        $xml = new \SimpleXMLElement($geocode);

        if (empty($geocode)) {
            return NULL;
        }

        $geo_object  = $xml->GeoObjectCollection->featureMember->GeoObject;
        $geo_address = $geo_object->metaDataProperty->GeocoderMetaData->AddressDetails->Country;

        $result = array(
            'address' => (string) $geo_address->AddressLine,
            'region'  => (string) $geo_address->AdministrativeArea->AdministrativeAreaName,
            'subarea' => (string) $geo_address->AdministrativeArea->SubAdministrativeArea->SubAdministrativeAreaName,
            'city'    => (string) $geo_address->AdministrativeArea->SubAdministrativeArea->Locality->LocalityName,
            'point'   => (string) $geo_object->Point->pos,
        );

        return $result;
    } // function get_address($latitude, $longitude)
}

// END Location library class

/* End of file Location.php */
/* Location: /application/libraries/Location.php */
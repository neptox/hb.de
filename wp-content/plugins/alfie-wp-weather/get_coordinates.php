<?php
/**
 *
 * ============ appcuarium ============
 *
 * Alfie ® Platform PHP SDK
 *
 * ====== Apps outside the box.® ======
 *
 * ------------------------------------
 *  Copyright © 2012 - 2014 Appcuarium
 * ------------------------------------
 *
 * E-mail: apps@appcuarium.com
 * Author: Sorin Gheata
 * Version: 1.1
 *
 * ====================================
 *
 */

header( 'Content-type: application/json' );

require_once 'vendor/autoload.php';
use GeoIp2\Database\Reader;

$reader = new Reader( 'vendor/GeoLite2/GeoLite2-City.mmdb' );

try {
    $record = $reader->city( $_SERVER[ 'REMOTE_ADDR' ] );
    $result = array(
        'data' => array(
            'country' => $record->country->name,
            'region' => $record->mostSpecificSubdivision->name,
            'city' => $record->city->name,
            'lat' => $record->location->latitude,
            'lng' => $record->location->longitude
        )
    );

}
catch ( Exception $e ) {
    if ( $e->getMessage() !== '' ) {
        $result = array(
            'data' => array(
                'country' => 0,
                'region' => 0,
                'city' => 0,
                'lat' => 0,
                'lng' => 0
            )
        );
    }
}

echo json_encode( $result );
<?php

function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyDrRC4kWAjqyK5toxfikbIg-ugY9WTcbco';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
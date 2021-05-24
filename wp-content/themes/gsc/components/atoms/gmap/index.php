<?php /*
<!-- gmap element with base styling -->
<div id="gsc-gmap" class=""></div>
 */

 $defaults = [
  "content" => [
    "id" => "",
    "class" => "",
    "attrs" => []
  ]
 ];
gsc_define("gmap", $defaults, function ($data) {

  $misc_attrs = "";
  if (!empty($data["content"]["attrs"])) {
    foreach ($data["content"]["attrs"] as $attr_name=>$attr_value) {
      $misc_attrs .= "$attr_name='$attr_value'";
    }
  }

  $html = '<style type="text/css">
.acf-map {
    width: 100%;
    height: 400px;
    border: #ccc solid 1px;
    margin: 20px 0;
}

// Fixes potential theme css conflict.
.acf-map img {
   max-width: inherit !important;
}
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSs9Ip3jzJdmjBMx3drs7-mfKsJHHq_lo"></script>
<script type="text/javascript">
(function( $ ) {

/**
 * initMap
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */
function initMap( $el ) {

    // Find marker elements within map.
    var $markers = $el.find(".marker");

    // Create gerenic map.
    var mapArgs = {
      disableDefaultUI: true,
        zoom        : $el.data("zoom") || 16,
        mapTypeId   : google.maps.MapTypeId.ROADMAP,
        gestureHandling: "cooperative"
    };
    var map = new google.maps.Map( $el[0], mapArgs );

    // Add markers.
    map.markers = [];
    $markers.each(function(){
        initMarker( $(this), map );
    });

    // Center map based on markers.
    centerMap( map );

    // Return map instance.
    return map;
}

/**
 * initMarker
 *
 * Creates a marker for the given jQuery element and map.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @param   object The map instance.
 * @return  object The marker instance.
 */
function initMarker( $marker, map ) {

    // Get position from marker.
    var lat = $marker.data("lat");
    var lng = $marker.data("lng");
    var latLng = {
        lat: parseFloat( lat ),
        lng: parseFloat( lng )
    };

    const infoWindow = new google.maps.InfoWindow();

    // Create marker instance.
    var marker = new google.maps.Marker({
        position : latLng,
        map: map,
        title: "Hi-De Liners"
    });

    // Append to reference for later use.
    map.markers.push( marker );

    // If marker contains HTML, add it to an infoWindow.
    if( $marker.html() ){

        // Create info window.
        var infowindow = new google.maps.InfoWindow({
            content: ""
        });

        // Show info window when marker is clicked.
        google.maps.event.addListener(marker, "click", function() {
            infowindow.open( map, marker );
        });
    }
}

/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   object The map instance.
 * @return  void
 */
function centerMap( map ) {

    // Create map boundaries from all map markers.
    var bounds = new google.maps.LatLngBounds();
    map.markers.forEach(function( marker ){
        bounds.extend({
            lat: marker.position.lat(),
            lng: marker.position.lng()
        });
    });

    // Case: Single marker.
    if( map.markers.length == 1 ){
        map.setCenter( bounds.getCenter() );

    // Case: Multiple markers.
    } else{
        map.fitBounds( bounds );
    }
}

// Render maps on page load.
$(document).ready(function(){
    $(".acf-map").each(function(){
        var map = initMap( $(this) );
    });
});

})(jQuery);
</script>';

// $location = get_field('google_map', 'option');

if ( $location ) {
  $address = "";

  $html .= "<div class='acf-map' data-zoom='16'>";
  $html .= "<div class='marker' data-lat='" . $location['lat'] . "' data-lng='" . $location['lng'] . "'> </div>";
  $html .= "</div>";

  foreach( array('street_number', 'street_name', 'city', 'state', 'post_code', 'country') as $i => $k) {
    if (isset($location[$k])) {
      $address .= sprintf( '<span class="segment-%s">%s</span>, ', $k, $location[ $k ] );
    }
  }

  $address = trim( $address, ', ');
}

return $html;

});

gsc_meta("gmap", [ATOM]);
gsc_test("gmap", "interactive map with markers ", function() {
  echo gsc("gmap", []);
});

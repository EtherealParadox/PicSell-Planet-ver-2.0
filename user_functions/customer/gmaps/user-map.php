    <?php
    include 'locations_model.php';
    //get_unconfirmed_locations();exit;
    ?>

        <script type="text/javascript"
        
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXuNd8wbu-NaASSm5G16Rba7Xc-mvSFs">
        </script>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
    </head>
    <body>
    <style>

        /* Optional: Makes the sample page fill the window. */
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
        #map {
            height: 90%;
        }
    </style>
        

        <div id="map"></div>
        <script>
            
            /**
             * Create new map
             */
            var map;
            var marker;
            var infowindow;
            var red_icon =  "gmaps/confirmed.png" ;
            var purple_icon =  'gmaps/pending.png' ;
            var locations = <?php get_all_locations() ?>;
            console.log(locations)
            var myOptions = {
                zoom: 12,
                center:new google.maps.LatLng(14.6799, 120.5411),
                mapTypeId: 'roadmap'
            };
            map = new google.maps.Map(document.getElementById('map'), myOptions);

            


            /**
             * loop through (Mysql) dynamic locations to add markers to map.
             */
            var i ; var confirmed = 0;
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                    map: map,
                    icon :  red_icon,
                    html: 
                    '<div><h6>'+locations[i][4]+'</h6></div>' +
                    '<div class="stuff">' +
                        '<div style="font-size: 15px">' +
                            locations[i][0] + ' ' + locations[i][1] + 
                        '</div>' +
                    '</div>'
                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow = new google.maps.InfoWindow();
                        /*confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                        $("#confirmed").prop(confirmed,locations[i][4]);
                        $("#id").val(locations[i][0]);
                        $("#description").val(locations[i][3]);
                        $("#form").show();*/
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
            


        </script>
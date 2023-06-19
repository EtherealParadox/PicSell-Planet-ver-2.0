<?php
include 'locations_model.php';
//get_unconfirmed_locations();exit;
?>

    
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <script type="text/javascript"
    
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-DRY0VAfHvgM2v94_6koo4gCr7bQXQ8A">
    </script>
</head>
<body>
    
<style>

    /* Optional: Makes the sample page fill the window. */
 /* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
    #map {
        height: 100%;
    }

    td{
        font-weight: bold;
    }

    .lctn_delete_btn {
        margin-top: 5px;
        text-align: center;
    }

    .lctn_delete_btn button{
        border: none;
        padding: 5px 10px 5px 10px;
        font-size: 12px;
    }

    .lctn_delete_btn button:hover {
        background-color: #114481;
        color: #fed136;
        cursor: pointer;
    }
</style>
    

    <div id="map"></div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        /**
         * Create new map
         */
        var map;
        var marker;
        var infowindow;
        var red_icon =  "gmaps/pending.png" ;
        var purple_icon =  'gmaps/confirmed.png' ;
        var locations = <?php get_all_locations() ?>;
        var myOptions = {
            zoom: 12,
            center:new google.maps.LatLng(14.6799, 120.5411),
            mapTypeId: 'roadmap'
        };
        map = new google.maps.Map(document.getElementById('map'), myOptions);

        /*function initMap() {
            var bataan = {lat: 14.6799, lng: 120.5411};
            infowindow = new google.maps.InfoWindow();
            map = new google.maps.Map(document.getElementById('map'), {
                center: bataan,
                zoom: 12
            });
        
        
            var i ; var confirmed = 0;
            for (i = 0; i < locations.length; i++) {
                var loc;
                if(locations[i][4] === '1')
                {
                    locations[i][4] === '1' ? loc = locations[i][3] : loc = locations[i][3] + 'pending'
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        icon :  red_icon,
                        disableAutoPan: true,
                        html: 
                            '<div><h6>'+loc+'</h6></div>' +
                            '<div class="address">' +
                                '<div jstcache="4" jsinstance="0" class="address-line full-width" jsan="7.address-line,7.full-width">' +
                                    'mwe' +
                                '</div>' +
                                '<div jstcache="4" jsinstance="1" class="address-line full-width" jsan="7.address-line,7.full-width">' +
                                    'mwe' +
                                '</div>' +
                                '<div jstcache="4" jsinstance="2" class="address-line full-width" jsan="7.address-line,7.full-width">' +
                                    'mwe' +
                                '</div>' +
                                '<div jstcache="4" jsinstance="*3" class="address-line full-width" jsan="7.address-line,7.full-width">' +
                                    'mwe' +
                                '</div>' +
                            '</div>'
                    });
                
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                            $("#confirmed").prop(confirmed,locations[i][4]);
                            $("#id").val(locations[i][0]);
                            $("#description").val(locations[i][3]);
                            $("#form").show();
                            infowindow.setContent(marker.html);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
                
                if(locations[i][4] === '0')
                {
                    locations[i][4] === '1' ? loc = locations[i][3] : loc = locations[i][3] + 'pending'
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        icon :   purple_icon,
                        disableAutoPan: true,
                        html: "<div>\n" +
                    "<table class=\"map1\">\n" +
                    "<tr>\n" +
                    "<td><b>Description:</b></td>\n" +
                    "<td><b disabled id='manual_description' placeholder='Description'>mwe"+loc+"</b></td></tr>\n" +
                    "</table>\n" +
                    "</div>"
                    });
                
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                            $("#confirmed").prop(confirmed,locations[i][4]);
                            $("#id").val(locations[i][0]);
                            //$("#description").append(locations[i][3]);
                            document.getElementById('description').innerHTML = "Some text to enter";
                            $("#form").show();
                            infowindow.setContent(marker.html);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
        }*/

        /**
         * Global marker object that holds all markers.
         * @type {Object.<string, google.maps.LatLng>}
         */
        var markers = {};

        /**
         * Concatenates given lat and lng with an underscore and returns it.
         * This id will be used as a key of marker to cache the marker in markers object.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {string} Concatenated marker id.
         */
        var getMarkerUniqueId= function(lat, lng) {
            return lat + '_' + lng;
        };

        /**
         * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
         * This function can be useful for getting new coordinates quickly.
         * @param {!number} lat Latitude.
         * @param {!number} lng Longitude.
         * @return {google.maps.LatLng} An instance of google.maps.LatLng object
         */
        var getLatLng = function(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        };

        /**
         * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
         */
        var addMarker = google.maps.event.addListener(map, 'click', function(e) {
            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point
            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
            var marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,
                id: 'marker_' + markerId,
                html: 
                /*"    <div id='info_"+markerId+"'>\n" +
                "        <table class=\"map1\">\n" +
                "            <tr>\n" +
                "                <td><a>Save this location?</a></td>\n" +
                "                <td> </td></tr>\n" +
                "            <tr><td></td><td><input type='button' value='Save' onclick='saveData("+lat+","+lng+")'/></td></tr>\n" +
                "        </table>\n" +
                "    </div>"*/
                    '<style>' +
                        'textarea {' +
                            'padding: 3px;' +
                            'font-size: 20px;' +
                            'resize: none;' +
                        '}' +
                        'textarea::-webkit-scrollbar {' +
                            'width: 10px;' +
                        '}' +
                        'textarea::-webkit-scrollbar-track {' +
                            'background: #f1f1f1;' +
                        '}' +
                        'textarea::-webkit-scrollbar-thumb {' +
                            'background: #888;'  +
                        '}' +
                        'textarea::-webkit-scrollbar-thumb:hover {' +
                            'background: #555;' +
                        '}' +
                        '.markerBtn input{' +
                            'font-size: 15px;' +
                        '}' +
                        '.markerBtn input:not(:first-child){' +
                            'margin-left: 10px;' +
                        '}' +                         
                    '</style>' +
                    '<div id="info_'+markerId+'" style="text-align:center">' +
                        '<textarea id="mapDesc" rows="4" cols="30" maxlength=100 placeholder="Enter what branch is this.."></textarea>' +
                        '<h5>Save this location?</h5>' +
                        '<div class="markerBtn">' +
                            '<input type="button" value="Save" onclick="save('+lat+','+lng+')"/>' +
                            '<input type="button" value="Remove" onclick="removeMarkByBtn('+lat+','+lng+')"/>' +
                        '</div>' +
                    '</div>' 

            });
            markers[markerId] = marker; // cache marker in markers object
            bindMarkerEvents(marker); // bind right click event to marker
            bindMarkerinfo(marker); // bind infowindow with click event to marker
        });

        function save(lat, lng)
        {
            Swal.fire({
                confirmButtonText: "Proceed",
                showCancelButton: true,
                html:
                    '<h4>Proceed adding this marker to the database?</h4>'
            }).then((result) => {
                    if (result.isConfirmed) {
                        saveData(lat, lng)
                    }
			})
        }

        function removeMarkByBtn(lat, lng)
        {
            var markerId = getMarkerUniqueId(lat, lng); // get marker id by using clicked point's coordinate
            var marker = markers[markerId]; // find marker
            removeMarker(marker, markerId);
        }

        /**
         * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerinfo = function(marker) {
            google.maps.event.addListener(marker, "click", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker);
                // removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
         */
        var bindMarkerEvents = function(marker) {
            google.maps.event.addListener(marker, "rightclick", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                removeMarker(marker, markerId); // remove it
            });
        };

        /**
         * Removes given marker from map.
         * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
         * @param {!string} markerId Id of marker.
         */
        var removeMarker = function(marker, markerId) {
            marker.setMap(null); // set markers setMap to null to remove it from map
            delete markers[markerId]; // delete marker instance from markers object
        };


        /**
         * loop through (Mysql) dynamic locations to add markers to map.
         */
        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {
            var loc;
            
            if(locations[i][5] == <?php echo $_SESSION['login_user_id']?> && locations[i][4] === '0'){
                locations[i][4] === '0' ? stat = '<div>Pending</div>' : stat = '';
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                    map: map,
                    icon :   red_icon,
                    html: 
                    '<div><h6>'+locations[i][7]+'</h6></div>' +
                    '<div class="stuff">' +
                        '<div style="font-size: 15px">' +
                        locations[i][6] +
                        '</div>' +
                        '<div>' +
                        locations[i][1] +
                        '</div>' +
                            stat +
                        '<div class="lctn_delete_btn">' +
                            '<button onclick=deleteLocation('+ locations[i][0] +')>Delete</button>' + 
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
            if(locations[i][5] == <?php echo $_SESSION['login_user_id']?> && locations[i][4] === '1')
            {
                marker = new google.maps.Marker({

                position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                map: map,
                icon :   purple_icon,
                html: 
                '<div><h6>'+locations[i][7]+'</h6></div>' +
                '<div class="stuff">' +
                    '<div style="font-size: 15px">' +
                    locations[i][6] +
                    '</div>' +
                    '<div>' +
                    locations[i][1] +
                    '</div>' +
                    '<div class="lctn_delete_btn">' +
                        '<button onclick=deleteLocation('+ locations[i][0] +')>Delete</button>' + 
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
        }

        function deleteLocation(loc_id)
        {
            Swal.fire({
                confirmButtonText: "Proceed",
                showCancelButton: true,
                html:
                    '<h4>Proceed deleting this marker to the database?</h4>'
            }).then((result) => {
                    if (result.isConfirmed) {
                        deleteData(loc_id)
                    }
			})
        }

        /**
         * SAVE save marker from map.
         * @param lat  A latitude of marker.
         * @param lng A longitude of marker.
         */
        function saveData(lat,lng) {
            var description = document.getElementById('mapDesc').value;
            //alert(lat + "mwe" + lng + "mwe" + description)
            var url = 'gmaps/locations_model.php?add_location&lat=' + lat + '&lng=' + lng + '&desc=' + description + '&user=' + <?php echo $_SESSION['login_user_id']?>;
            downloadUrl(url, function(data, responseCode) {
                if (responseCode === 200  && data.length > 1) {
                    location.reload()
                }else{
                    console.log(responseCode);
                    console.log(data);
                    infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
                }
            });
        }

        function deleteData(loc_id) {
            var url = 'gmaps/locations_model.php?delete_location&loc_id=' + loc_id;
            downloadUrl(url, function(data, responseCode) {
                if (responseCode === 200  && data.length > 1) {
                    location.reload()
                }else{
                    console.log(responseCode);
                    console.log(data);
                    infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
                }
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    callback(request.responseText, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }




    </script>

    <div style="display: none" id="form">
        <table class="map1">
            <tr>
                <td><b>Description:</b></td>
                <td><p id='description'><b></b></p></td>
            </tr>
            <tr>
                <td><b>Confirm Location ?:</b></td>
                <td><input id='confirmed' type='checkbox' name='confirmed'></td>
            </tr>
        </table>
    </div>
    
    
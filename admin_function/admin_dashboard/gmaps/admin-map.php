
<?php
include_once 'locations_model.php';
?>
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
</style>

<div id="map"></div>

<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-DRY0VAfHvgM2v94_6koo4gCr7bQXQ8A">
        
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!------ Include the above in your HEAD tag ---------->
<script>
    var map;
    var marker;
    var infowindow;
    var red_icon =  "gmaps/confirmed.png" ;
    var purple_icon =  'gmaps/pending.png' ;
    var locations = <?php get_all_locations() ?>;
    var myOptions = {
        zoom: 12,
        center:new google.maps.LatLng(14.6799, 120.5411),
        mapTypeId: 'roadmap'
    };
    map = new google.maps.Map(document.getElementById('map'), myOptions);

    /*function initMap() {
        var france = {lat: 14.6799, lng: 120.5411};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: france,
            zoom: 12
        });


        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
                html: document.getElementById('form')
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
            
            if(locations[i][4] === '1')
            {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                    map: map,
                    icon :  red_icon,
                    html: 
                    '<div><h3>'+locations[i][7]+'</h3></div>' +
                    '<div class="stuff">' +
                        '<div style="font-size: 15px">' +
                        locations[i][6] +
                        '</div>' +
                        '<div>' +
                        locations[i][1] +
                        '</div>' +
                    '</div>'
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow = new google.maps.InfoWindow();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
            else
            {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                    map: map,
                    icon :  purple_icon,
                    html: 
                        '<style>' +
                            '.markerBtn{' +
                                'margin-top: 10px;' +
                                'text-align: center;' +
                            '}' +
                            '.markerBtn input{' +
                                'font-size: 15px;' +
                            '}' +
                            '.markerBtn input:not(:first-child){' +
                                'margin-left: 10px;' +
                            '}' +                         
                        '</style>' +
                        '<div><h3>'+locations[i][7]+'</h3></div>' +
                        '<div class="stuff">' +
                            '<div style="font-size: 15px">' +
                            locations[i][6] +
                            '</div>' +
                            '<div>' +
                            locations[i][1] +
                            '</div>' +
                            '<div class="markerBtn">' +
                                '<input type="button" value="Save" onclick="save('+locations[i][2]+','+locations[i][3]+')"/>' +
                            '</div>' +
                        '</div>'
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow = new google.maps.InfoWindow();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        }
    }*/

    var i ; var confirmed = 0;
    for (i = 0; i < locations.length; i++) {
        if(locations[i][4] === '1')
        {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                map: map,
                icon :  red_icon,
                html: 
                '<div><h3>'+locations[i][7]+'</h3></div>' +
                '<div class="stuff">' +
                    '<div style="font-size: 15px">' +
                    locations[i][6] +
                    '</div>' +
                    '<div>' +
                    locations[i][1] +
                    '</div>' +
                '</div>'
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
        else
        {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                map: map,
                icon :  purple_icon,
                html: 
                    '<style>' +
                        '.markerBtn{' +
                            'margin-top: 10px;' +
                            'text-align: center;' +
                        '}' +
                        '.markerBtn input{' +
                            'font-size: 15px;' +
                        '}' +
                        '.markerBtn input:not(:first-child){' +
                            'margin-left: 10px;' +
                        '}' +                         
                    '</style>' +
                    '<div><h3>'+locations[i][7]+'</h3></div>' +
                    '<div class="stuff">' +
                        '<div style="font-size: 15px">' +
                        locations[i][6] +
                        '</div>' +
                        '<div>' +
                        locations[i][1] +
                        '</div>' +
                        '<div class="markerBtn">' +
                            '<input type="button" value="Save" onclick="save('+locations[i][0]+','+locations[i][2]+','+locations[i][3]+','+locations[i][5]+')"/>' +
                        '</div>' +
                    '</div>'
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }

    function save(loc_id, lat, lng, user_id)
    {
        Swal.fire({
            confirmButtonText: "Proceed",
            showCancelButton: true,
            html:
                '<h4>Proceed to confirm this marker to the database?</h4>'
        }).then((result) => {
                if (result.isConfirmed) {
                    updateData(loc_id, lat, lng, user_id)
                }
		})
    }

    function updateData(loc_id, lat, lng, user_id)
    {
        //alert(loc_id+'mwe'+lat+'mwe'+lng+'mwe'+user_id)
        var url = 'gmaps/locations_model.php?update_location&loc_id=' + loc_id + '&user_id=' + user_id ;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
            }
        });
    }

    function saveData() {
        var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
        var id = document.getElementById('id').value;
        var url = 'gmaps/locations_model.php?confirm_location&id=' + id + '&confirmed=' + confirmed ;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
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
            <input name="id" type='hidden' id='id'/>
            <td><b>Description:</b></td>
            <td><input type="text" disabled id='description' placeholder='Description'><b></b></input></td>
        </tr>
        <tr>
            <td><b>Confirm Location ?:</b></td>
            <td><input id='confirmed' type='checkbox' name='confirmed'></td>
        </tr>

        <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
    </table>
</div>


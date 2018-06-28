<?php header("Access-Control-Allow-Origin: *");

session_start();

$response = file_get_contents('https://opendata.paris.fr/explore/dataset/autolib-disponibilite-temps-reel/download/?format=json&timezone=Europe/Paris');
if ($response) {
//    print_r($response);

} else {
    echo "la page est introuvable" . PHP_EOL;
    die();
}

$stations = json_decode($response, TRUE);




$_SESSION['JSON'] = $response;


?>
<!DOCTYPE html>
<html class='use-all-space'>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset='UTF-8'>
    <title>Lib'Auto</title>
    <meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='sdk/map.css'/>
    <link rel='stylesheet' type='text/css' href='css/elements.css'/>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    {{-- Styles --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @yield('template_linked_css')

    <script type='text/javascript' src='js/form.js'></script>
    <script type='text/javascript' src='sdk/tomtom.min.js'></script>
    <style>
        label {
            display: flex;
            align-items: center;
            margin: 2px;
        }
        select {
            flex: auto;
            margin-left: 10px;
        }
    </style>
</head>
<body class='use-all-space'>
@include('partials.nav')
<div class='map-container use-all-space'>
    <div id='map' class='use-all-space'></div>
</div>
<script>

    var json$ = <?php echo $_SESSION['JSON']; ?>

    // Define your product name and version
    tomtom.setProductInfo('MapsWebSDKExamplesSelfhosted', '4.29.1-SNAPSHOT');
    var instructionMarker, groupMarkersLayer;
    // Setting TomTom keys
    tomtom.routingKey('VjndxUA6O7sRRStVkF7RpXoECWiV4tVt');
    tomtom.searchKey('VjndxUA6O7sRRStVkF7RpXoECWiV4tVt');

    // Creating map
    var map = tomtom.L.map('map', {
        key: 'VjndxUA6O7sRRStVkF7RpXoECWiV4tVt',
        source: 'vector',
        basePath: '/sdk',
        center: [48.85, 2.33],
        zoom: 12,
    });
    map.zoomControl.setPosition('topright');
    var routingLocaleService = new tomtom.localeService();
    var unitSelector = tomtom.unitSelector.getHtmlElement(tomtom.globalUnitService);
    var languageSelector = tomtom.languageSelector.getHtmlElement(tomtom.globalLocaleService, 'search');
    var routingLanguageSelector = tomtom.languageSelector.getHtmlElement(routingLocaleService, 'routing');

    var unitRow = document.createElement('div');
    var unitLabel = document.createElement('label');
    unitLabel.innerHTML = 'Unit of measurement';
    unitLabel.appendChild(unitSelector);
    unitRow.appendChild(unitLabel);
    unitRow.className = 'input-container';

    var langRow = document.createElement('div');
    var langLabel = document.createElement('label');
    langLabel.innerHTML = 'Search language';
    langLabel.appendChild(languageSelector);
    langRow.appendChild(langLabel);
    langRow.className = 'input-container';

    var routingRow = document.createElement('div');
    var routingLabel = document.createElement('label');
    routingLabel.innerHTML = 'Routing language';
    routingLabel.appendChild(routingLanguageSelector);
    routingRow.appendChild(routingLabel);
    routingRow.className = 'input-container';

    tomtom.controlPanel({
        position: 'bottomright',
        title: 'Settings',
        collapsed: true
    })
        .addTo(map)
        .addContent(unitRow)
        .addContent(routingRow)
        .addContent(langRow);

    // Adding route-inputs widget
    var routeInputsInstance = tomtom.routeInputs().addTo(map);

    // Adding route-on-map widget
    var routeOnMapView = tomtom.routeOnMap({
        generalMarker: {
            draggable: true,
            zIndexOffset: 10
        },
        serviceOptions: {
            instructionsType: 'tagged'
        }
    }).addTo(map);

    // Adding route-instructions widget
    var routeInstructionsInstance = tomtom.routeInstructions({
        size: [240, 230],
        position: 'topleft',
        instructionGroupsCollapsed: true
    }).addTo(map);

    var markerOptions = {
        icon: tomtom.L.icon({
            iconUrl: '/images/puce.png',
            iconSize: [30, 34],
            iconAnchor: [15, 34]
        })
    };


    console.log(json$[1])



    for(var i=0; i<json$.length; i++){
        var indiv = json$[i];

        var status;
        var legende = null;

        if(indiv.fields.status === "ok"){
            status = "open"
            legende = "<div>Voitures disponibles : "+indiv.fields.cars+" </div> <div>Places disponibles : "+indiv.fields.charge_slots+" </div>"
        } else{
            status = "close"
            legende = "Station fermée";
        }

        var txt = "<div class='popup'>" +
                    "<div id='adressAutolib'><div> "+ indiv.fields.address +"&nbsp;</div>" +
                    "<div> "+ indiv.fields.postal_code + " " + indiv.fields.city +" </div></div><hr>" +
                  legende +
            "</div>"

        if(indiv.geometry !== null){
            //console.log(indiv.geometry.coordinates)

            var marker = tomtom.L.marker([indiv.geometry.coordinates[1],indiv.geometry.coordinates[0]], {
                icon: tomtom.L.icon({
                    iconUrl: '/images/'+status+'.png',
                    iconSize: [12, 12],
                    iconAnchor: [6, 6]
                })
            }).addTo(map);

            marker.bindPopup(txt);
        }


    }

    var lastEventObject;
    // Connecting route-inputs with route-on-map widget
    routeInputsInstance.on(routeInputsInstance.Events.LocationsFound, function(eventObject) {
        lastEventObject = eventObject;
        routeOnMapView.draw(eventObject.points);
    });
    routeInputsInstance.on(routeInputsInstance.Events.LocationsCleared, function(eventObject) {
        lastEventObject = eventObject;
        routeInstructionsInstance.hide();
        routeOnMapView.draw(eventObject.points);
    });

    // Connecting route-on-map with route-instructions widget
    routeOnMapView.on(routeOnMapView.Events.RouteChanged, function(eventObject) {
        routeInstructionsInstance.updateGuidanceData(eventObject.instructions);
    });

    // Update search inputs when the user change the route dragging the markers over the map
    routeOnMapView.on(routeOnMapView.Events.MarkerDragEnd, function(eventObject) {
        var location = eventObject.markerIndex === 0 ? routeInputsInstance.searchBoxes[0] :
            routeInputsInstance.searchBoxes.slice(-1)[0];
        location.setResultData(eventObject.object);
    });

    // Focus a instruction step in the map when the use select it on the route-instructions widget
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionClickedSelect, function(eventObject) {
        map.setView({lat: eventObject.point.latitude, lon: eventObject.point.longitude}, 14);
    });

    // Focus a instructions group in the map when the use select it on the route-instructions widget
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionGroupClickedExpand, function(eventObject) {
        zoomToPoints(eventObject.points);
    });
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionGroupClickedCollapse, function(eventObject) {
        zoomToPoints(eventObject.points);
    });

    // Show popups over the points in the map when the use move the cursor over the instruction steps
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionHoverOn, function(eventObject) {
        var position = {
            lat: eventObject.point.latitude,
            lon: eventObject.point.longitude
        };
        instructionMarker = tomtom.L.marker(position, {
            icon: tomtom.L.icon({
                iconUrl: '/sdk/../img/instruction_marker.svg',
                iconSize: tomtom.L.Browser.retina ? [34, 34] : [20, 20],
                iconAnchor: tomtom.L.Browser.retina ? [17, 17] : [10, 10]
            }),
            zIndexOffset: 100
        });
        map.addLayer(instructionMarker);
        tomtom.L.popup({autoPan: false, maxWidth: 150}).setLatLng(position)
            .setContent(eventObject.message.toString()).openOn(map);
    });
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionHoverOff, function() {
        map.removeLayer(instructionMarker);
        instructionMarker = undefined;
        map.closePopup();
    });

    // Hightlight all the steps of a group in the map when the use move the cursor over an instructions group
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionGroupHoverOn, function(eventObject) {
        var markersForGroup = eventObject.points.map(function(instruction) {
            return tomtom.L.marker({
                lat: instruction.latitude,
                lon: instruction.longitude
            }, {
                icon: tomtom.L.icon({
                    iconUrl: '/sdk/../img/instruction_marker.svg',
                    iconSize: tomtom.L.Browser.retina ? [25, 25] : [15, 15],
                    iconAnchor: tomtom.L.Browser.retina ? [13, 13] : [7, 7]
                }),
                zIndexOffset: 100
            });
        });
        groupMarkersLayer = tomtom.L.layerGroup(markersForGroup);
        map.addLayer(groupMarkersLayer);
    });
    routeInstructionsInstance.on(routeInstructionsInstance.Events.InstructionGroupHoverOff, function() {
        map.removeLayer(groupMarkersLayer);
    });

    function zoomToPoints(points) {
        var latLons = points.map(function(point) {
            return tomtom.L.latLng(point.latitude, point.longitude);
        });
        map.fitBounds(tomtom.L.latLngBounds(latLons));
    }

    routingLocaleService.on(L.LocaleService.Events.LOCALE_CHANGED, function(evt) {
        var langCode = evt.getLanguageCode();
        routeOnMapView.options.serviceOptions.language = langCode;
        if (lastEventObject) {
            routeOnMapView.draw(lastEventObject.points);
        }
    });


    for (var i=0; i < document.getElementsByClassName("leaflet-marker-icon").length; i++) {
        document.getElementsByClassName("leaflet-marker-icon")[i].onclick = function(){
            console.log(document.getElementById('adressAutolib'))
            setTimeout(function(){ document.getElementsByClassName("icon-end-black")[0].value = document.getElementById('adressAutolib').innerText }, 15);

        }
    };


</script>
</body>
</html>

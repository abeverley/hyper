var mymap = L.map('mapid').setView([51.508, -0.20], 15);


L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWJldmVybGV5IiwiYSI6ImNrMm9qMTNieDB4OHAzYm56ZjNqaDY1ZjYifQ.8f0Lz6dUbO3R1eNzuJPeTg', {
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/light-v10' // Or streets-v11 outdoors-v11 dark-v10
}).addTo(mymap);

function onEachFeature(feature, layer) {
    var popupContent = '';
    if (feature.properties.status) {
        popupContent = popupContent + '<u>' + feature.properties.status + '</u><br>';
    }
    if (feature.properties.comments1) {
        popupContent = popupContent + '<p>' + jQuery('<div />').text(feature.properties.comments1).html() + '</p>';
    }
    if (feature.properties.comments2) {
        popupContent = popupContent + '<p>' + jQuery('<div />').text(feature.properties.comments2).html() + '</p>';
    }


    if (feature.properties && feature.properties.popupContent) {
        popupContent += feature.properties.popupContent;
    }

    layer.bindPopup(popupContent, {maxWidth : 560});
}

var markers1 = L.markerClusterGroup({maxClusterRadius:2});
var markers2 = L.markerClusterGroup({maxClusterRadius:2});

var icons = {
    blue: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    gold: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    orange: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    yellow: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    violet: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    black: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    green: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    grey: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    }),
    red: new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    })
};


var layer1;
var layer2;

// $ doesn't seem to be available for some reason
jQuery(document).ready(function($){
    var json_file = "/wp-content/json/" + $('#mapid').data('json');
    console.log("file: "+json_file);

    fetch(json_file)
        .then(function(response) { return response.json() })
        .then(function(json) {

            var overlayMaps = {};
            var bounds;
            $.each(json.layers, function(index, layer_json) {
                var layer = L.geoJSON([layer_json.geojson], {

                    style: function (feature) {
                        return feature.properties && feature.properties.style;
                    },
                    //filter: function (feature) { return feature.properties.hpe},

                    onEachFeature: onEachFeature,

                    pointToLayer: function (feature, latlng) {
                        return L.marker(latlng, {
                            icon: icons[feature.properties.icon],
                        });
                    }
                });
                var markers = L.markerClusterGroup({maxClusterRadius:2});
                markers.addLayer(layer);
                mymap.addLayer(markers);

                var this_bounds = markers.getBounds();
                if (!bounds) {
                    bounds = this_bounds;
                }
                console.log(this_bounds);
                bounds.extend(this_bounds.min);
                bounds.extend(this_bounds.max);
                overlayMaps[layer_json.name] = markers;
            });
            mymap.fitBounds([
                [51.51664, -0.16218],
                [51.51214, -0.17389]
            ]);
            //mymap.fitBounds(bounds);
            console.log(bounds);
            L.control.layers(null, overlayMaps,{collapsed:false}).addTo(mymap);

            // HPE
            /*
            var layer1 = L.geoJSON([json.geojson], {

                style: function (feature) {
                    return feature.properties && feature.properties.style;
                },
                filter: function (feature) { return feature.properties.hpe},

                onEachFeature: onEachFeature,

                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {
                        icon: icons[feature.properties.icon],
                    });
                }
            });
            markers1.addLayer(layer1);
            mymap.addLayer(markers1);
            mymap.fitBounds(markers1.getBounds());

            // Others
            var layer2 = L.geoJSON([json.geojson], {

                style: function (feature) {
                    return feature.properties && feature.properties.style;
                },
                filter: function (feature) { return ! feature.properties.hpe},

                onEachFeature: onEachFeature,

                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {
                        icon: icons[feature.properties.icon],
                    });
                }
            });
            markers2.addLayer(layer2);
            //mymap.addLayer(markers2);
            //mymap.fitBounds(markers2.getBounds());
            */
        });

    //var overlayMaps = {
    //        "Inside triangle": markers1,
    //        "Outside triangle": markers2
    //};

    var popup = L.popup();
});

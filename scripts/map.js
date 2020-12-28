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
    var popupContent = '<u>' + feature.properties.status + '</u><br>'
        + '<p>' + jQuery('<div />').text(feature.properties.comments1).html() + '</p>'
        + '<p>' + jQuery('<div />').text(feature.properties.comments2).html() + '</p>';

    if (feature.properties && feature.properties.popupContent) {
        popupContent += feature.properties.popupContent;
    }

    layer.bindPopup(popupContent, {maxWidth : 560});
}

var markers1 = L.markerClusterGroup({maxClusterRadius:2});
var markers2 = L.markerClusterGroup({maxClusterRadius:2});

var icons = {
    icon_pedestrian_fatal: L.icon({
        iconUrl: '/images/iconmonstr-accessibility-2-32-black.png',
        iconSize: [32, 32],
    }),
    icon_pedestrian_serious: L.icon({
        iconUrl: '/images/iconmonstr-accessibility-2-32-red.png',
        iconSize: [32, 32],
    }),
    icon_pedestrian_slight: L.icon({
        iconUrl: '/images/iconmonstr-accessibility-2-32-amber.png',
        iconSize: [32, 32],
    }),
    icon_cyclist_fatal: L.icon({
        iconUrl: '/images/iconmonstr-bicycle-5-32-black.png',
        iconSize: [32, 32],
    }),
    icon_cyclist_serious: L.icon({
        iconUrl: '/images/iconmonstr-bicycle-5-32-red.png',
        iconSize: [32, 32],
    }),
    icon_cyclist_slight: L.icon({
        iconUrl: '/images/iconmonstr-bicycle-5-32-amber.png',
        iconSize: [32, 32],
    }),
    other: L.icon({
        iconUrl: '/images/iconmonstr-star-1-32-amber.png',
        iconSize: [32, 32],
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


//L.marker([51.5, -0.09], {icon: greenIcon}).addTo(map);

var layer1;
var layer2;

fetch("/wp-content//json/points.json")
    .then(function(response) { return response.json() })
    .then(function(json) {
        // HPE
        var layer1 = L.geoJSON([json], {

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
        var layer2 = L.geoJSON([json], {

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
    });

var overlayMaps = {
        "Inside triangle": markers1,
        "Outside triangle": markers2
};
L.control.layers(null, overlayMaps,{collapsed:false}).addTo(mymap);

var popup = L.popup();

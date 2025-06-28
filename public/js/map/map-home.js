document.addEventListener('DOMContentLoaded', function () {
    window.map = L.map('map').setView([-18.8792, 47.5079], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    loadCommunes(map);
    loadDistricts(map);
    loadInfrastructures(map);
});

/**
@param {L.Map} map 
 */
function loadCommunes(map) {
    fetch(`${BASE_URL}/commune/getAll`) 
        .then(response => response.json())
        .then(data => {
            const geojson = L.geoJSON(data, {
                style: {
                    color: 'blue',
                    weight: 2,
                    fillOpacity: 0.1
                },
                onEachFeature: function (feature, layer) {
                    const name = feature.properties?.name || feature.properties?.des_commun || 'Commune';

                    // layer.bindPopup(name);

                    layer.bindTooltip(name, {
                        permanent: true,
                        direction: "center",
                        className: "commune-label"
                    });
                }
            }).addTo(map);

            if (geojson.getBounds().isValid()) {
                map.fitBounds(geojson.getBounds());
            }
        })
        .catch(error => console.error('Erreur chargement GeoJSON communes:', error));
}

function loadDistricts(map) {
    fetch(`${BASE_URL}/district/getAll`)
        .then(response => response.json())
        .then(data => {
            L.geoJSON(data, {
                style: {
                    color: 'green',
                    weight: 2,
                    fillOpacity: 0.1
                },
                onEachFeature: function (feature, layer) {
                    if (feature.properties && feature.properties.des_fiv) {
                        // layer.bindPopup(feature.properties.des_fiv);
                    }
                }
            }).addTo(map);
        })
        .catch(error => console.error('Erreur chargement GeoJSON districts:', error));
}

function loadInfrastructures(map) {
    fetch(`${BASE_URL}/infrastructure/getAll`)
        .then(response => response.json())
        .then(data => {
            L.geoJSON(data, {
                pointToLayer: function (feature, latlng) {
                    const iconUrl = feature.properties?.icon;

                    const customIcon = L.icon({
                        iconUrl: iconUrl ? `${BASE_URL}/public/img/infra_icon/${iconUrl}` : `${BASE_URL}/public/img/infra_icon/default.png`,
                        iconSize: [24, 24],       
                        iconAnchor: [16, 32],     
                        popupAnchor: [0, -32]     
                    });

                    return L.marker(latlng, { icon: customIcon });
                },
                onEachFeature: function (feature, layer) {
                    const props = feature.properties;
                    const nom = props.nom || "Infrastructure";
                    const descriptif = props.descriptif || "";

                    let popupContent = `<strong>${nom}</strong>`;
                    if (descriptif) {
                        popupContent += `<br>${descriptif}`;
                    }

                    layer.bindPopup(popupContent);
                }
            }).addTo(map);
        })
        .catch(error => console.error('Erreur chargement infrastructures:', error));
}


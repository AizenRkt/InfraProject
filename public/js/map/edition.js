document.addEventListener('DOMContentLoaded', function () {
    // Attendre que la carte soit initialisée
    if (window.map) {
        initMapClickHandler();
    } else {
        // Si la carte n'est pas encore prête, attendre un peu
        setTimeout(() => {
            if (window.map) {
                initMapClickHandler();
            }
        }, 100);
    }
});

/**
 * Initialise le gestionnaire de clic sur la carte
 */
function initMapClickHandler() {
    // Ajouter un gestionnaire de clic sur la carte
    window.map.on('click', function(e) {
        // Récupérer les coordonnées du clic
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        console.log('Clic sur la carte aux coordonnées:', lat, lng);
        
        // Ouvrir le modal
        openInfrastructureModal(lat, lng);
    });
}

/**
 * Ouvre le modal d'ajout d'infrastructure
 * @param {number} lat - Latitude du point cliqué
 * @param {number} lng - Longitude du point cliqué
 */
function openInfrastructureModal(lat, lng) {
    // Stocker les coordonnées pour utilisation ultérieure
    window.selectedCoordinates = { lat, lng };
    
    // Ajouter les coordonnées au formulaire si nécessaire
    addCoordinatesToForm(lat, lng);
    
    // Ouvrir le modal Bootstrap
    const modal = new bootstrap.Modal(document.getElementById('large'));
    modal.show();
}

/**
 * Ajoute les coordonnées au formulaire
 * @param {number} lat - Latitude
 * @param {number} lng - Longitude
 */
function addCoordinatesToForm(lat, lng) {
    // Chercher s'il y a déjà des champs pour les coordonnées
    let latInput = document.querySelector('input[name="latitude"]');
    let lngInput = document.querySelector('input[name="longitude"]');
    
    // Si les champs n'existent pas, les créer
    if (!latInput || !lngInput) {
        const form = document.getElementById('infraForm');
        
        // Créer les champs cachés pour les coordonnées
        if (!latInput) {
            latInput = document.createElement('input');
            latInput.type = 'hidden';
            latInput.name = 'latitude';
            form.appendChild(latInput);
        }
        
        if (!lngInput) {
            lngInput = document.createElement('input');
            lngInput.type = 'hidden';
            lngInput.name = 'longitude';
            form.appendChild(lngInput);
        }
    }
    
    // Définir les valeurs
    latInput.value = lat;
    lngInput.value = lng;
}

/**
 * Ajoute un marqueur temporaire à l'emplacement sélectionné
 * @param {number} lat - Latitude
 * @param {number} lng - Longitude
 */
function addTemporaryMarker(lat, lng) {
    // Supprimer le marqueur temporaire précédent s'il existe
    if (window.tempMarker) {
        window.map.removeLayer(window.tempMarker);
    }
    
    // Ajouter un nouveau marqueur temporaire
    window.tempMarker = L.marker([lat, lng], {
        icon: L.divIcon({
            className: 'temp-marker',
            html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white;"></div>',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(window.map);
}

// Gestionnaire pour la soumission du formulaire
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('infraForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Vous pouvez ajouter ici une validation ou un traitement spécial
            console.log('Formulaire soumis avec coordonnées:', window.selectedCoordinates);
            
            // Supprimer le marqueur temporaire après soumission
            if (window.tempMarker) {
                window.map.removeLayer(window.tempMarker);
                window.tempMarker = null;
            }
        });
    }
});

// Amélioration : ajouter un marqueur temporaire lors du clic
function openInfrastructureModal(lat, lng) {
    // Stocker les coordonnées pour utilisation ultérieure
    window.selectedCoordinates = { lat, lng };
    
    // Ajouter un marqueur temporaire
    addTemporaryMarker(lat, lng);
    
    // Ajouter les coordonnées au formulaire
    addCoordinatesToForm(lat, lng);
    
    // Ouvrir le modal Bootstrap
    const modal = new bootstrap.Modal(document.getElementById('large'));
    modal.show();
}

// Nettoyer le marqueur temporaire si le modal est fermé sans soumission
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('large');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function() {
            // Supprimer le marqueur temporaire si le modal est fermé
            if (window.tempMarker) {
                window.map.removeLayer(window.tempMarker);
                window.tempMarker = null;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const lat = parseFloat(urlParams.get('lat'));
    const lon = parseFloat(urlParams.get('lon'));

    if (!isNaN(lat) && !isNaN(lon) && window.map) {
        window.map.setView([lat, lon], 17); // zoom niveau 17
        L.popup()
            .setLatLng([lat, lon])
            .setContent("Nouvelle infrastructure ajoutée ici.")
            .openOn(window.map);
    }
});

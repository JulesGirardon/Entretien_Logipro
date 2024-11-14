const map = new maplibregl.Map({
    container: 'map',
    style: 'https://api.maptiler.com/maps/streets/style.json?key=Jeb04tCk3RTY9RpbGz9r',
    center: [0, 0],
    zoom: 2
});

// Marqueur de base
const marker = new maplibregl.Marker()
    .setLngLat([0, 0])
    .addTo(map);

// Changement point quand clic sur la carte
map.on('click', (event) => {
    const lngLat = event.lngLat;
    marker.setLngLat(lngLat);
    
    document.getElementById('latitude').value = lngLat.lat.toFixed(8); 
    document.getElementById('longitude').value = lngLat.lng.toFixed(8);
});
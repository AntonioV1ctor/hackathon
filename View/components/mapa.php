<!-- DIV DO MAPA (precisa ter altura definida) -->
<div id="mapaRoteiro" class="w-full h-96 rounded-xl border"></div>

<!-- LEAFLET -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
function initMapaRoteiro(locais) {

    if (!locais || locais.length === 0) {
        console.warn("Nenhum local recebido para o mapa.");
        return;
    }

    // Centraliza no MS
    const map = L.map("mapaRoteiro").setView([-20.5, -55], 6);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
    }).addTo(map);

    let coords = [];

    locais.forEach(loc => {
        const pos = loc.coord;

        coords.push(pos);

        L.marker(pos)
            .addTo(map)
            .bindPopup(`<b>${loc.nome}</b><br>${loc.cidade}`);
    });

    // Linha entre os pontos
    L.polyline(coords, { color: "#00a6bf", weight: 4 }).addTo(map);

    // Ajustar zoom
    map.fitBounds(coords);
}
</script>

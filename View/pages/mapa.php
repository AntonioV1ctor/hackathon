<?php require_once '../components/head.php'; ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<body class="bg-slate-100 flex flex-col min-h-screen">

    <?php require_once '../components/navbar.php'; ?>

    <main class="flex-grow relative">

        <!-- Map Container -->
        <div id="map" class="absolute inset-0 w-full h-full z-0"></div>

        <!-- Overlay Title (Optional) -->
        <div
            class="absolute top-4 left-1/2 transform -translate-x-1/2 z-[500] bg-white/90 backdrop-blur px-6 py-2 rounded-full shadow-lg">
            <h1 class="text-lg font-bold text-[#004e64]">Mapa Gastronômico</h1>
        </div>

    </main>

    <?php
    require_once '../../Model/restauranteModel.php';
    $restauranteModel = new RestauranteModel();
    $restaurantes = $restauranteModel->listarRestaurantes();
    ?>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Inicializa o mapa (focado no MS por padrão, ou ajustado dinamicamente)
        var map = L.map('map').setView([-20.4697, -54.6201], 6); // Campo Grande/MS coordinates approx

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Dados dos restaurantes do PHP para JS
        var restaurantes = <?php echo json_encode($restaurantes); ?>;
        var markers = [];

        restaurantes.forEach(function (r) {
            if (r.lat && r.log) {
                var lat = parseFloat(r.lat);
                var log = parseFloat(r.log);

                if (!isNaN(lat) && !isNaN(log)) {
                    var marker = L.marker([lat, log]).addTo(map);

                    var popupContent = `
                        <div class="w-48">
                            <img src="${r.caminho_imagem}" class="w-full h-24 object-cover rounded-t-lg mb-2" alt="${r.nome}">
                            <h3 class="font-bold text-[#004e64] text-sm">${r.nome}</h3>
                            <p class="text-xs text-slate-600 mb-2">${r.cidade} - ${r.categoria}</p>
                            <a href="/hackathon/View/pages/detalhesRestaurante.php?id=${r.id}" class="block w-full text-center bg-[#00a6bf] text-white text-xs py-1.5 rounded hover:bg-[#0090a4] transition">
                                Ver Detalhes
                            </a>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    markers.push(marker);
                }
            }
        });

        // Ajustar zoom para mostrar todos os marcadores se houver algum
        if (markers.length > 0) {
            var group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    </script>

</body>

</html>
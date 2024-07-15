<?php

require_once 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $CONFIG["PATH"]["VIEWS"]["LOGIN"]);
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Akses ke halaman tidak sah'
    ];
    exit;
} else {
    require $CONFIG["PATH"]["APP"] . "data/scripts/leaflet/get_marker.php";
}

include_once $CONFIG["PATH"]["APP"] . "inc/html.head.php";

?>

<body>
    <!-- Nav bar 
        ------------------------------------ -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand">Aplikasi Hotel</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="add_marker.php" id="addMarkerLink" data-bs-animation="true" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="manual" title="Tambahkan marker">Tambah Marker</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu lain
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="edit_marker.php">Kelola Markers</a></li>
                            <li><button class="dropdown-item" id="centerMapByAllMarkerBtn" data-bs-toggle="tooltip" data-bs-placement="right" title="Memusatkan tampilan peta berdasarkan marker">Pusatkan berdasarkan marker</button></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./data/scripts/auth/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- OffCanvas Element 
        ------------------------------------ -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <span id="markerName" class="d-flex justify-content-center fw-bold"></span>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body px-4 fs-6">
            <p id="markerLatLng" class="form-text"></p>
            <img class="img-fluid mb-2" src="">
            <p id="markerDescription" class="form-text"></p>
        </div>
    </div>

    <!-- Map Container 
        ------------------------------------ -->
    <div>
        <div id="map" style="height: 90vh;"></div>
    </div>

    <script src="./assets/lib/leaflet/leaflet.js"></script>
    <script src="./assets/js/init-leaflet.js"></script>
    <script>
        // Variabel parsing dari PHP SESION
        var json = <?= json_encode($_SESSION); ?>;

        // Tampilkan alert jika ada
        if (json.alert !== undefined) {

            Swal.fire({
                title: json.alert.title,
                icon: json.alert.type,
                toast: true,
                showConfirmButton: false,
                position: "top-end",
                timer: 3000,
            })

            <?php unset($_SESSION['alert']); ?>
        }
    </script>
    <script src="./assets/js/dashboard.js"></script>

</body>

</html>
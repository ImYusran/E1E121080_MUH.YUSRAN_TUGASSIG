<?php

require_once 'config.php';

session_start();
require_once $CONFIG["PATH"]["APP"] . '/data/scripts/leaflet/get_marker.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $CONFIG["PATH"]["VIEWS"]["LOGIN"]);
}

include_once $CONFIG["PATH"]["APP"] . "inc/html.head.php";

?>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand">Aplikasi Hotel</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Tampilan Utama</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu lain
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="add_marker.php">Tambah marker</a></li>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card m-5">
                    <div class="card-body">
                        <form id="inputForm" action="./data/scripts/leaflet/update_marker.php" method="POST">
                            <fieldset id="formFieldSet" disabled>
                                <input type="hidden" id="inputMarkerId" value="" name="marker_id">
                                <div class="mb-3">
                                    <div id="formText" class="form-text">Klik pada marker untuk mulai mengubah informasi marker</div>
                                </div>
                                <div class="mb-3">
                                    <label for="inputLat" class="form-label">Latitude</label>
                                    <input type="text" class="form-control form-control-sm" id="inputLat" value="" name="lat">
                                </div>
                                <div class="mb-3">
                                    <label for="inputLng" class="form-label">Longitude</label>
                                    <input type="text" class="form-control form-control-sm" id="inputLng" value="" name="lng">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control form-control-sm" id="inputName" value="" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Kelas Hotel</label>
                                    <select  class="form-control form-control-sm" id="description" autocomplete="off" value="" name="description">
                                    <option value="Pilih Kelas Hotel" selected>Pilih Kelas Hotel</optio>
                                    <option value="Hotel Bintang 5">Hotel Bintang 5</option>
                                    <option value="Hotel Bintang 4">Hotel Bintang 4</option>
                                    <option value="Hotel Bintang 3">Hotel Bintang 3</option>
                                    <option value="Hotel Bintang 2">Hotel Bintang 2</option>
                                    <option value="Hotel Bintang 1">Hotel Bintang 1</option>
                                    <option value="Tidak Berbintang">Tidak Berbintang</option>
                                </select>
                                </div>
                                <button type="submit" name="action" value="update" id="submitBtn" class="btn btn-primary btn-sm">Ubah</button>
                                <button type="submit" name="action" value="delete" id="deleteBtn" class="btn btn-outline-danger btn-sm">Hapus</button>
                                <button type="button" id="resetBtn" class="btn btn-outline-secondary btn-sm" onclick="resetForm(populateMarker)">Reset</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div id="map" style="height: 90vh;"></div>
            </div>
        </div>
    </div>

    <script src="./assets/lib/leaflet/leaflet.js"></script>
    <script src="./assets/js/init-leaflet.js"></script>
    <script>
        var json = <?= json_encode($_SESSION); ?>;
        console.log(json)

        if (json.alert !== undefined) {
            Swal.fire({
                title: json.alert.title,
                icon: json.alert.type,
                text: json.alert.text,
                toast: true,
                showConfirmButton: false,
                position: "top-end",
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            })
            <?php unset($_SESSION['alert']); ?>
        }
    </script>
    <script src="./assets/js/edit_marker.js"></script>

</body>

</html>
<?php

require_once 'config.php';

session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . $CONFIG["PATH"]["VIEWS"]["DASHBOARD"]);
    $_SESSION['alert'] = [
        'type' => 'info',
        'title' => 'Anda perlu Logout untuk mengakses halaman ini'
    ];
    exit;
}

include_once $CONFIG["PATH"]["APP"] . "inc/html.head.php";
?>

<body>

    <div class="bg-image" style="background-image: url(./assets/images/background.png); height: 100vh;">
        <div class="mask" style="background-color: rgba(255, 255, 255, 0.9);">
            <div class="container">
                <div class="d-flex flex-column justify-content-center w-50 vh-100 align-items-center mx-auto">
                    <div class="row">
                        <div class="col">
                            <h4>Leaflet JS Demo</h4>
                        </div>
                    </div>
                    <form class="row g-3" method="POST" action="./data/scripts/auth/login.php">
                        <div class="col-12">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" autocomplete="off" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" autocomplete="off" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <button id="submitBtn" type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="col-md-6 d-flex flex-row justify-content-end">
                            <a href="register.php">Register</a>
                        </div>
                        <input type="hidden" name="action" value="login">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var json = <?= json_encode($_SESSION); ?>;
        console.log(json);

        if (json.alert !== undefined) {
            Swal.fire({
                title: json.alert.title,
                icon: json.alert.type,
                text: json.alert.text,
                toast: true,
                showConfirmButton: false,
                position: "top-end",
                timer: 3000,
            })
            <?php unset($_SESSION['alert']); ?>
        }
    </script>
    <script src="./assets/js/index.js"></script>

</body>

</html>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="assets/img/favicon/a2z_logo.png" type="image/x-icon">
  <title>ClothEase</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- External Css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body style="background-color: #F5F5F9 !important;">
  <div class="login_container vh-100">

    <!-- navbar -->
    <nav class="navbar shadow header">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="assets/img/favicon/a2z_logo.png" alt="Bootstrap" width="auto" height="40">
        </a>
      </div>
    </nav>

    <!-- login section -->
    <div class="container h-75 py-5 ">
      <div class="row d-flex align-items-center">
        <div class="col-sm-6 col-lg-8">
          <div class="p-4 content">
            <div>
              <img src="assets/img/icons/brands/clothease_logo.png" alt="clothease" height="auto" width="350">
            </div>
            <p class="fs-6 mt-3 text-secondary">This system is developed by A2Z IT HUB PVT. LTD. company on 2024.<br> If
              you have any query about system/software you can contact us on <br>
              Call / Whatsapp +91 9011144920 <br>Visit Our Website https://a2zithub.com/
            </p>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="card card-body bg-light w-100  h-100 p-4 border-0 shadow">


            <form method="POST" action="auth.php">
              <div class="mb-3">
                <label for="loginusername" class="form-label fw-semibold">Username</label>
                <input type="text" class="form-control rounded-1 bg-white" name="username" id="loginusername"
                  aria-describedby="username">
                <div id="username" class="form-text">Your unique username to app</div>
              </div>
              <div class="mb-3">
                <label for="loginPassword" class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control rounded-1 bg-white" id="loginPassword">
                <div id="password" class="form-text">Your Password</div>
              </div>
              <?php
              if (isset($_GET['message'])) {
                echo "<p style='color: green;'>{$_GET['message']}</p>";
              }
              if (isset($_GET['error'])) {
                echo '<div style="color: red;">' . htmlspecialchars($_GET['error']) . '</div>';
              }
              ?>
              <button type="submit" class="btn btn-primary mt-2 rounded-1 px-4 py-3 text-center fw-semibold w-100">Secure
                Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- footer -->
    <div class="container copy">
      <div class="row ">
        <div class="col-md-12 d-flex justify-content-center">
          <p class="fs-6 text-secondary">© ClothEase
            <script>
              document.write(new Date().getFullYear());
            </script>,
            <a href="https://a2zithub.org/" target="_blank" class=" text-decoration-none fw-semibold">A2Z IT HUB PVT
              LTD</a>
          </p>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap 5.3v script -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>
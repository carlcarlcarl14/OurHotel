<?php
require_once(__DIR__ . '/config/database.php');
session_start();

if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$user_id = (int)$_SESSION['id'];
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE id = ? LIMIT 1");
if (!$stmt) {
  session_unset();
  session_destroy();
  header('Location: login.php');
  exit;
}
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$valid_user = $result && mysqli_num_rows($result) === 1;
mysqli_stmt_close($stmt);

if (!$valid_user) {
  session_unset();
  session_destroy();
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Website</title>
  <link rel="stylesheet" href="home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-info sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="./admin/Bellagio-Hotel-Casino-Las-Vegas.webp" alt="" width="30" height="24" class="d-inline-block align-text-top rounded-circle">
        <span class="text-danger">Our</span>Hotel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
          </li>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#schedule">Our Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#book_now">Book Now</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#team">Team Section</a>
          </li>
          <li class="nav-item">
            <button class="btn btn-danger"><a class="nav-link" href="logout.php">Logout</a></button>
          </li>
      </div>
    </div>
  </nav>

  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./hotel.jpg" class="d-block w-100" alt="Hotel">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
      <div class="carousel-item">
        <img src="./admin/Bellagio-Hotel-Casino-Las-Vegas.webp" class="d-block w-100" alt="Hotel exterior">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
      <div class="carousel-item">
        <img src="./hotel.jpg" class="d-block w-100" alt="Hotel">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!--about-->
  <section id="about" class="about section-padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col col-md-12 col-12">
          <div class="about-img">
            <img src="./admin/Bellagio-Hotel-Casino-Las-Vegas.webp" alt="Lobby" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-8 col-md-12 ps-lg-5 mt-md-5">
          <div class="about-text">
            <h2>We Provide Best Quality <br> Services Ever</h2>
            <p>With a contemporary design and a calming ambience, the quality of service and facilities of 5-star brands yet offers the best value for money.
              Expect well-appointed rooms and first-class amenities during your stay.</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!--services-->
  <section id="services" class="services section-padding">
    <div class="container">
      <h1 class=" text-center mb-5">Our Services</h1>
      <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
          <div class="card text-white text-center bg-dark pb-2">
            <div class="card-body">
              <i class="bi bi-subtract"></i>
              <h3 class="card-title">Best Quality</h3>
              <p class="lead">The Perfect Room
                Choose from over 100,000 hotels in more than 200 countries around the world.</p>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4 col-lg-4">
          <div class="card text-white text-center bg-dark pb-2">
            <div class="card-body">
              <i class="bi bi-slack"></i>
              <h3 class="card-title">Sustainability</h3>
              <p class="lead">Strict Focus on Privacy
                All bookings are protected with best-in-class privacy and security standards.</p>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4 col-lg-4">
          <div class="card text-white text-center bg-dark pb-2">
            <div class="card-body">
              <i class="bi bi-playstation"></i>
              <h3 class="card-title">Integrity</h3>
              <p class="lead">We compile the best rates from several top suppliers to make it easy to book the perfect hotel.</p>
            </div>
          </div>
        </div>
      </div>
  </section>

  <!--rooms-->
  <section id="schedule" class="schedule section-padding">
    <div class="container">
      <h1 class="text-center">Our Rooms</h1>
      <div class="row justify-content-center">
        <?php
        $sql = "SELECT * FROM rooms";
        $query = mysqli_query($conn, $sql);
        if ($query) {
          while ($row = mysqli_fetch_assoc($query)) {
            $room_name = $row['room_name'];
            $room_description = $row['room_description'];
            $room_price = $row['room_price'];
            $room_img = $row['room_img'];

            echo '<div class="col-8 col-sm-8 col-md-4 col-lg-3 mt-4">
            <div class="card h-100">
              <img src="./admin/upload_img/' . $room_img . '" class="card-img-top">
              <div class="card-body text-center ">
                <h5 class="card-title">' . $room_name . '</h5>
                <p class="card-text">' . $room_description . '</p>
                <p class="card-text">Price: ' . $room_price . '</p>
                <a href="#book_now" class="btn btn-primary">Book</a>
              </div>
            </div>
          </div>';
          }
        }
        ?>
      </div>
    </div>
  </section>

  <!--book now-->
  <section id="book_now" class="book_now section-padding">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h4 class="text-center">Hotel Booking Form</h4>
            </div>
            <div class="card-body">
              <form action="index.php" method="POST">
                <?php
                if (isset($_POST['submit'])) {
                  $name = $_POST['name'];
                  $email = $_POST['email'];
                  $check_in_date = $_POST['check_in_date'];
                  $check_out_date = $_POST['check_out_date'];
                  $number_of_rooms = $_POST['number_of_rooms'];

                  $sql = "INSERT INTO booking (name, email, check_in_date, check_out_date, number_of_rooms) VALUES('$name', '$email', '$check_in_date', '$check_out_date', '$number_of_rooms')";
                  $query = mysqli_query($conn, $sql);
                  if ($query) {
                    echo '<script>alert("Booked successfully!");</script>';
                  } else {
                    echo '<script>alert("Booking unsuccessful!");</script>';
                  }
                }
                ?>
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter your name">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                  <label for="checkin">Check-In Date</label>
                  <input type="date" class="form-control" name="check_in_date">
                </div>
                <div class="form-group">
                  <label for="checkout">Check-Out Date</label>
                  <input type="date" class="form-control" name="check_out_date">
                </div>
                <div class="form-group">
                  <label for="rooms">Number of Rooms</label>
                  <input type="number" class="form-control" name="number_of_rooms" min="1">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <!--team-->
  <section id="team" class="team section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-header text-center pb-5">
            <h1>Contact Us</h1>
            <p>We compile the best rates from all the top suppliers to make it easy to book the perfect room. For specific hotel questions not related to a booking on Guest ReservationsTM, please reach out to the us directly.</p>
          </div>
        </div>

        <div class="=col-12 col-md-6 col-lg-3">
          <div class="card text-center">
            <div class="card-body"></div>
            <img src="C:\Users\Barangay Sua - SK\Desktop\Lovenelle's File\love.jpg" alt="" class="img-fluid rounded-circle">
            <h3 class="card-title py-2">Lovenelle Betinol</h3>

            <p class="socials">
              <i class="bi bi-twitter text-dark mx-1">lvnellebtnl</i>
            </p>
            <p> <i class="bi bi-facebook text-dark mx-1">Love Nelle Betinol</i></p>
            <i class="bi bi-instagram text-dark mx-1">lvnellebtnl</i>
            </p>
          </div>
        </div>

        <div class="=col-12 col-md-6 col-lg-3">
          <div class="card text-center">
            <div class="card-body"></div>
            <img src="C:\Users\Barangay Sua - SK\Desktop\Lovenelle's File\relan.jpg" alt="" class="img-fluid rounded-circle">
            <h3 class="card-title py-2">Relan Melliza</h3>


            <p class="socials">
              <i class="bi bi-twitter text-dark mx-1">Relan Melliza</i>
            </p>
            <p> <i class="bi bi-facebook text-dark mx-1">Relan Melliza</i></p>
            <i class="bi bi-instagram text-dark mx-1">Relan Mellizal</i>
            </p>
          </div>
        </div>

        <div class="=col-12 col-md-6 col-lg-3">
          <div class="card text-center">
            <div class="card-body"></div>
            <img src="C:\Users\Barangay Sua - SK\Desktop\Lovenelle's File\rose.jpg" alt="" class="img-fluid rounded-circle">
            <h3 class="card-title py-2">Joshua Hilbero</h3>


            <p class="socials">
              <i class="bi bi-twitter text-dark mx-1">joshuahilbero</i>
            </p>
            <p> <i class="bi bi-facebook text-dark mx-1">Joshua Hilbero</i></p>
            <i class="bi bi-instagram text-dark mx-1">Joshua Hilbero</i>
            </p>
          </div>
        </div>

        <div class="=col-12 col-md-6 col-lg-3">
          <div class="card text-center">
            <div class="card-body"></div>
            <img src="C:\Users\Barangay Sua - SK\Desktop\Lovenelle's File\april.jpg" alt="" class="img-fluid rounded-circle">
            <h3 class="card-title py-2">Aprilyn Vistal</h3>


            <p class="socials">
              <i class="bi bi-twitter text-dark mx-1">Aprilyn Vistal</i>
            </p>
            <p> <i class="bi bi-facebook text-dark mx-1">Aprilyn Vistal</i></p>
            <i class="bi bi-instagram text-dark mx-1">Aprilyn Vistal</i>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark p-2 text-center">
    <div class="container">
      <p class="text-white">All Rights Reserved 2023</p>
    </div>
  </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>

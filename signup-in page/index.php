<?php
//FILE PHP INI SEBAGAI PLACEHOLDER UNTUK HOMEPAGE
session_start();
require __DIR__ . "/database.php";
$guessUser = false;
if (isset($_SESSION["login"])) {

    $data = $_SESSION["username"];

    $sql = "SELECT * FROM customer WHERE username = '$data'";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    $guessUser = false;
} else {
    $guessUser = true;
}


$nowPlaying = query("SELECT * FROM movie");
// $upcoming = query("SELECT * FROM movie");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    require_once "../Partials/header.php";
    ?>




    <style>
        div.content {
            position: absolute;
            width: 100vw;
            height: 100vh;
            z-index: 10;
        }

        div.content-inner {
            position: relative;
            width: 100vw;
            height: 100vh;


        }

        div.bg-mid {
            position: fixed;
            width: 100vw;
            min-height: 100vh;
            z-index: 8;
            background-color: #181818;
            filter: blur(5px);
            opacity: 0.8;

        }

        h1 {
            font-family: 'Vina Sans', sans-serif;
        }

        h4 {
            font-weight: bold;
        }

        .carousel-caption {
            background-color: rgb(16, 8, 94, 0.6);
            border-radius: 10px;

        }

        .image-container {
            position: relative;
            width: 100%;
            padding-top: 133.33%;
            /* This sets the aspect ratio to 4:3. Adjust this value to get the aspect ratio you want. */
            overflow: hidden;
            transform-style: preserve-3d;
            transition: transform 1s;
        }

        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        .image-container img {
            object-fit: cover;
        }

        .card {
            background: rgb(238, 174, 202);
            background: radial-gradient(circle, rgba(238, 174, 202, 1) 0%, rgba(148, 187, 233, 1) 100%);
            /* Change this to your desired color */
        }



        .image-container:hover {
            /* transform: rotateY(180deg); */
            transform: scale(0.95);
            transition: transform .2s;
        }

        @keyframes pop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(2);
            }

            100% {
                transform: scale(1);
            }

        }
    </style>
    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css">
    <link rel="stylesheet" href="../Partials/confeti.css">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <?php
    if (isset($_GET["confirmP"])) {
        if ($_GET["confirmP"] == 1) {
            echo "<script>
                $(document).ready(function(){
                Swal.fire({
                    icon: 'success',
                    title: 'Order Success',
                    text: 'Your ticket has been sent record',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
                </script>";
        } else if ($_GET["confirmP"] == 0) {
            echo "<script>
                $(document).ready(function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Order Failed',
                    text: 'Your ticket has not been sent record',
                    showConfirmButton: false,
                    timer: 3000
                })
            });
                </script>";
        }

        $_GET["confirmP"] = "";
    }
    ?>

    <title>PCinemaU</title>
    <link rel="icon" type="image/png" href="../Partials/favIcon.png">


</head>

<body style="overflow-x: hidden;">
    <section>

    </section>
    <div class="bg-mid">
    </div>

    <div class="content">

        <div style="position: fixed; top:-20px; right:50%">
            <div class=" confeti pumping" style="position: absolute; z-index: 90;
                                        right:50%;
                                        top:20px;
                                        cursor: pointer;">
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark text-bg-dark sticky-top" ;>
            <div class="container-fluid">
                <a class="navbar-brand ps-3" href="index.php" style="font-weight: bold;">PCinemaU</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php#nowplaying"><i class="bi bi-camera-reels-fill"></i> Now Playing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#upcoming"><i class="bi bi-film"></i> Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#theatre"><i class="bi bi-geo-alt-fill"></i> Theatre</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="bi bi-person-circle"></i> Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">


                                <?php if (!$guessUser) : ?>
                                    <li><a class="dropdown-item" href="profile-page.php">My Data</a></li>
                                    <li><a class="dropdown-item" href=" logout.php">Log Out</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="../signup-in page/signin-page.php">Sign In</a></li>
                                    <li><a class="dropdown-item" href="../signup-in page/signup-page.php">Sign Up</a></li>
                                <?php endif; ?>


                            </ul>
                        </li>

                    </ul>
                    <form class="d-flex" method="get" action="searchPage.php">
                        <select class="form-select w-75 me-2" name="genre">

                            <option><span class="dropdown-item genre">All</span></option>
                            <?php
                            $movieGenres = [
                                "Action",
                                "Comedy",
                                "Drama",
                                "Sci-Fi",
                                "Horror",
                                "Romance",
                                "Thriller",
                                "Adventure",
                                "Animation",
                                "Fantasy",
                                "Crime",
                                "Family"
                            ];

                            foreach ($movieGenres as $genre) : ?>
                                <option><span class="dropdown-item genre"><?= $genre ?></span></option>
                            <?php endforeach;
                            ?>


                        </select>
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="key">
                        <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container text-light pt-3">

            <!-- Carousel -->
            <div class="row pt-5">
                <div class="col-lg-9 col-12">
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
                        </div>

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="2000">
                                <img src="../Assets/Endgame.jpg" alt="" class="d-block" style="width:100%">

                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Avenger: Endgame</h4>
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <img src="../Assets/yourname.jpg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Kimi No Na Wa</h4>
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <img src="../Assets/Fast9.jpg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Fast 9</h4>
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <img src="../Assets/aquaman.jpeg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Aquaman: The Lost Kingdom</h4>
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <img src="../Assets/transformer.jpg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Transformer: Age Of Extinction</h4>
                                </div>
                            </div>

                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>




                </div>
                <div class="col">
                    <?php
                    if (!$guessUser) : ?>

                        <div class="card" style="
background: rgb(251,246,63);
background: radial-gradient(circle, rgba(251,246,63,1) 0%, rgba(252,70,107,1) 100%);">
                            <div class="card-body">
                                <h1 class="card-title text-uppercase text-center" style="font-size:3em; ">WELCOME @<?php echo htmlspecialchars($user["username"]) ?></h1>
                            </div>
                            <div class="card-footer">
                                <div class="row row-cols-lg-1 row-cols-1 gy-1 row-cols-sm-2 row-cols-md-2">
                                    <div class="col">
                                        <a href="profile-page.php" class="btn btn-dark w-100">Your Profile</a>
                                    </div>
                                    <div class="col">
                                        <a href="profileedit-page.php" class="w-100 btn btn-dark edit">Edit Profile</a>

                                    </div>
                                    <div class="col">
                                        <a href="favPage.php" class="btn btn-dark w-100">Favorite</a>
                                    </div>
                                    <div class="col">
                                        <a href="changepassword-page.php" class=" w-100 btn btn-dark change">Change Password</a>

                                    </div>
                                   
                                </div>
                                <div class="row pt-2">
                                        <div class="col-12">
                                        <a href="ticket-page.php" class="btn btn-primary w-100">Your Ticket</a>
                                        </div>
                                        
                                    </div>

                            </div>

                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <!-- //now playing section -->
            <h1 class="mt-5" id="nowplaying" data-aos="flip-right" data-aos-duration="2000">NOW PLAYING</h1>
            <hr class="mb-4 bg-warning">

            <div class="ajax-container">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-2 mb-5">

                    <?php foreach ($nowPlaying as $movie) : ?>
                        <?php if ($movie["status"] == 1) : ?>
                            <div class="col g-3">

                                <!-- <div class="card">
                                    
    <div ></div> -->
                                <div class="card movie-card h-100 " data-aos="zoom-in-up" data-aos-delay="300" data-aos-duration="1000" style="position: relative;">
                                    <p style="display: none;"><?= $movie["movie_id"] ?></p>
                                    <?php
                                    if (!$guessUser) : ?>

                                        <?php
                                        $user_id = getUserID($data);
                                        $movie_id = $movie["movie_id"];
                                        if (checkFav($movie_id, $user_id)) :
                                        ?>
                                            <button class="btn btn-dark fav-movie confeti pumping" style="position: absolute;z-index: 90;
                                        top: 10px;
                                        right: 10px;
                                        cursor: pointer;"><i class="bi bi-star-fill text-warning"></i>
                                            </button>
                                        <?php else : ?>

                                            <button class="btn btn-dark fav-movie confeti pumping" style="position: absolute;z-index: 90;
                                        top: 10px;
                                        right: 10px;
                                        cursor: pointer;"><i class="bi bi-star-fill text-secondary"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="image-container">

                                        <a href="moviedetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-dark">
                                            <img class="card-img-top" style="object-fit: cover ;" src="data:image;base64,<?php getMovie($movie["movie_id"]) ?>" alt="<?= $movie["movie_name"] ?>">
                                        </a>
                                    </div>

                                    <a href="moviedetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-dark">

                                        <div class="card-body">

                                            <!-- <p class="card-text">Action, Adventure, Fantasy, Sci-fi</p> -->
                                            <h6 class="card-title text-center text-uppercase"><b><?= $movie["movie_name"] ?></b></h6>

                                        </div>
                                    </a>
                                </div>
                                <!-- </div> -->
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>




                </div>
            </div>

            <!-- //upcoming -->
            <h1 class="mt-5 mb-2" id="upcoming" data-aos="flip-right" data-aos-duration="2000">UPCOMING MOVIE</h1>
            <hr class="mb-5 bg-warning">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-2 mb-5">
                <?php foreach ($nowPlaying as $movie) : ?>
                    <?php if ($movie["status"] == 0) : ?>
                        <div class="col">

                            <!-- <div class="card">
                    <div ></div> -->
                            <div class="card movie-card h-100 " data-aos="zoom-in-up" data-aos-delay="300" data-aos-duration="1000" style="position: relative;">
                                <!-- <i class="bi bi-star-fill"></i> -->
                                <p style="display: none;"><?= $movie["movie_id"] ?></p>
                                <?php
                                    if (!$guessUser) : ?>
                                <?php
                                $user_id = getUserID($data);
                                $movie_id = $movie["movie_id"];
                                if (checkFav($movie_id, $user_id)) :
                                ?>
                                    <button class="btn btn-dark fav-movie confeti pumping" style="position: absolute;z-index: 90;
                                        top: 10px;
                                        right: 10px;
                                        cursor: pointer;"><i class="bi bi-star-fill text-warning"></i>
                                    </button>
                                <?php else : ?>

                                    <button class="btn btn-dark fav-movie confeti pumping" style="position: absolute;z-index: 90;
                                        top: 10px;
                                        right: 10px;
                                        cursor: pointer;"><i class="bi bi-star-fill text-secondary"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                                <a href="moviedetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-dark">
                                    <div class="image-container">
                                        <img class="card-img-top" style="object-fit: cover ;" src="data:image;base64,<?php getMovie($movie["movie_id"]) ?>" alt="<?= $movie["movie_name"] ?>">

                                    </div>
                                </a>
                                <a href="moviedetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-dark">

                                    <div class="card-body">

                                        <!-- <p class="card-text">Action, Adventure, Fantasy, Sci-fi</p> -->
                                        <h6 class="card-title text-center text-uppercase"><b><?= $movie["movie_name"] ?></b></h6>


                                    </div>
                                </a>
                            </div>
                            <!-- </div> -->
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>


            <h1 class="mt-5" id="theatre" data-aos="flip-right" data-aos-duration="2000">Theatre</h1>
            <hr class="mb-4 bg-warning">
            <div class="bg-dark mb-5" style="overflow-y: auto;
    height: 500px;">
                <table class="table table-warning table-striped table-hover">
                    <thead class="table-dark p-5" data-aos="zoom-in">
                        <tr>
                            <th class="h5">Theatre</th>
                            <th class="h5">Phone-Number</th>
                            <th class="h5">City</th>
                        </tr>
                    </thead>
                    <tbody data-aos="zoom-in">
                        <?php

                        $theatre = getTheatre();
                        foreach ($theatre as $t) :
                        ?>
                            <tr>
                                <td><?= $t["theatre_name"] ?></td>
                                <td><?= $t["phone"] ?></td>
                                <td><?= $t["address"] ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>








        <footer data-aos="zoom-in">
            <div class="container-fluid bg-dark text-light p-3">
                <div class="row">
                    <div class="col">
                        <h5 class="ps-3">PCinemaU</h5>
                        <p class="p-2 ps-3">PCinemaU adalah sebuah website yang menyediakan informasi film-film terkini dan terupdate</p>
                    </div>
                    <div class="col">
                        <h5>Navigation</h5>
                        <ul class="list-unstyled">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="index.php#nowplaying">Now Playing</a></li>
                            <li><a href="index.php#upcoming">Upcoming</a></li>
                            <li><a href="index.php#theatre">Theatre</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <h5>Our Social Media</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <h5>Our Partner</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Cinema 21</a></li>
                            <li><a href="#">XXI</a></li>
                            <li><a href="#">CGV</a></li>
                            <li><a href="#">Cinepolis</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>


    <!-- Modal -->
    <!-- Button to Open the Modal -->


    <!-- The Modal -->
    <div class="modal modal-fullscreen-sm-down" id="MovieDetail">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Movie Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body text-bg-dark">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2">
                        <div class="col">
                            <img src="https://s1.bukalapak.com/img/68286857232/large/Poster_Film___Avengers_Endgame___Marvel_Studios___Movie_Post.jpg" alt="" style="width: 100%;">
                        </div>
                        <div class="col">

                            <table class="my-2">
                                <tr>
                                    <td>Genre</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>Duration</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>Release Date</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>Director</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>Cast</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>Synopsis</td>
                                    <td>:</td>
                                </tr>



                            </table>

                            <script>
                                $(document).ready(function() {
                                    $("#MovieDetail").find("td").addClass("pe-2");
                                })
                            </script>
                        </div>

                    </div>
                    <p class="pt-3 p-1 float-end" style="text-align: justify;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum quis asperiores ipsam enim cupiditate vel repellat ad quas consequatur minima! Eveniet adipisci ab facilis harum fugit aliquam laborum. Reprehenderit, aut!
                    </p>



                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>







    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../Partials/favAnimation.js"></script>
    <?php //if (!$guessUser) : ?>
        <script>
            // console.log("Initializing AOS...");
            AOS.init();
        </script>


        <script>
            $(document).ready(function() {
                $(".poster").hover(function() {
                    $(this).css("background-color", "rgba(0, 0, 0, 0.5)");
                    $(this).css("transition", "0.5s");
                }, function() {
                    $(this).css("background-color", "rgba(0, 0, 0, 0)");
                    $(this).css("transition", "0.5s");
                });
            })
        </script>



        <script>
            $(document).ready(function() {
                $(document).on("click", ".fav-movie", function() {
                    var $this = $(this);
                    console.log("Button clicked");
                    $this.css('animation', 'pop 0.3s');
                    // $this.css('background-color', 'red');



                    $this.on('animationend', function() {
                        $this.css('animation', '');
                    });
                 
                    m_id = $this.siblings("p").text();
                    u_id = <?= getUserID($data) ?>;
                    $.ajax({
                        url: "favProcess.php",
                        method: "GET",
                        data: {
                            mid: m_id,
                            uid: u_id
                        },
                        success: function(data) {
                            console.log(data);
                            if (data == "insert") {
                                $this.find("i").removeClass("text-secondary");
                                $this.find("i").addClass("text-warning");
                            } else if (data == "delete") {
                                $this.find("i").removeClass("text-warning");
                                $this.find("i").addClass("text-secondary");

                            }
                        }
                    })
                });
            });
        </script>
    <?php //endif ?>


</body>

</html>
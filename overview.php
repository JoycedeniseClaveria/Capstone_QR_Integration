
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f1fbff;
        }
        .section-padding {
            padding: 100px 0;
        }

        .carousel-item {
            height: 100vh;
            min-height:300px;
        }

        .carousel-caption {
            bottom: 220px;
            z-index:2;
        }

        .carousel-caption h5 {
            font-size:45px;
            text-transform:uppercase;
            letter-spacing: 2px;
            margin-top: 25px;
        }

        .coursel-caption p {
            width:60%;
            margin: auto;
            font-size: 18px;
            line-height: 1.9;
        }

        .carousel-inner::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left:0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .navbar-light .navbar-brand {
            color:rgb(0, 0, 0);
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing:2px;
        }

        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:focus {
            color: rgb(248, 212, 53);
        }

        .navbar-light .navbar-nav .navbar-link {
            color:rgb(0, 0, 0);
        }

        /* profile */
        .w-100 {
            height:100vh;
        }

        .portfolio .card-body i {
            font-size: 30px;
        }

        .project .card-body i {
            font-size: 20px;
        }

        .portfolio .card {
            box-shadow: 15px 15px 40px rgba(0, 0, 0, 0.15);
        }

        .services .card {
            box-shadow: 15px 15px 40px rgba(0, 0, 0, 0.15);
        }

        .project .card {
            box-shadow: 15px 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            margin-bottom: 5px;
        }
        /* .about-text h2{
            text-align: center;
        } */
        .map-area {
            width: 100%;
            height: 250;
            background: #f1fbff;
            box-shadow: rgba(0, 0, 0, 0.35)0 5px 15px; 
            margin-bottom: auto;
        }
        /* .map-area iframe{
            width: 100%;
            height: 100%;
            border: none;
        } */



        /* ========responsive css========= */

        @media only screen and (min-width: 768px) and (max-width:991px){
            .carousel-caption{
                bottom: 370px;
            }
            .carousel-caption p{
                width: 100%;

            }
            .card{
                margin-bottom: 30px;
            }
            .img-area img{
                width: 100px;
            }
        }

        @media only screen and (max-width: 767px){
            .navbar-nav{
                text-align: center;

            }
            .carousel-caption{
                bottom: 125px;

            }
            .carousel-caption h5{
            
                font-size: 17px;
            }
            .carousel-caption a{
                padding:10px 15px;


            }
            .carousel-caption p{
                width: 100%;
                line-height: 1.6;
                font-size:12px ;
            }
            .about-text{
                padding-top: 50px;
            }
            .card{
                margin-top:  20px;
            }
            /* .map-area{
                width: 100%;
                height: 400px;
            } */
            
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo1.png" style="width: 40%;">
                <!-- <span class="text-warning">FurEver</span>Finder -->
            </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#home">Home</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="#services">Portfolio</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#portfolio">Services</a>
              </li>
            
              <li class="nav-item">
                <a class="nav-link" href="#project">Program</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#contact">Contact</a>
              </li>
           
              
            </ul>
          </div>
        </div>
    </nav>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="pic1.png" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h5>Secaspi Animal Shelter</h5>
              <p>"Adopt, Don't Shop"</p>
              <p><a href="login.php" class="btn btn-warning mt-3">Visit Us</a></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="pic2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption ">
                <h5>Secaspi Animal Shelter</h5>
                <strong><p>"Adopt, Don't Shop"</p></strong>
                <p><a href="#" class="btn btn-warning mt-3">Visit Us</a></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="pic3.png" class="d-block w-100" alt="...">
            <div class="carousel-caption ">
                <h5>Secaspi Animal Shelter</h5>
                <p>"Adopt, Don't Shop"</p>
                <p><a href="#" class="btn btn-warning mt-3">Visit Us</a></p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="pic4.png" class="d-block w-100" alt="...">
            <div class="carousel-caption">
                <h5>Secaspi Animal Shelter</h5>
                <p>"Adopt, Don't Shop"</p>
                <p><a href="login.php" class="btn btn-warning mt-3">Visit Us</a></p>
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


        <!--About Section  -->

        <section id="about" class="about section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="img">
                            <img src="sample1.png" alt="shelter" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col ps-lg-5 mt-md-5">
                        <div class="about-text">
                            <h2>We Provide Best Quality Services </h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam maxime quaerat quis illo,
                             illum est dignissimos autem consequuntur quod accusantium porro et rem aliquid recusandae ratione optio ab! Eligendi, error.</p>
                             <a href="#" class="btn btn-warning"> Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

        <!-- Services Section -->

        <section id="portfolio" class="portfolio section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header text-center pb-5">
                            <h2>Our Services</h2>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.<br> Numquam architecto consequatur accusantium quia nesciunt labore,<br> explicabo exercitationem esse est nisi iste, eos,<br> non praesentium magnam quidem. Odio iusto iste architecto?</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card text-white text-center bg-dark pb-2">
                            <div class="card-body">
                                <i class="bi bi-house-heart-fill"></i>
                                <h3 class="card-title">Adoption and Foster Management </h3>
                                <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam reprehenderit odit quae! Ratione fugiat deserunt pariatur modi, iste, iusto sapiente necessitatibus ipsam recusandae consequuntur itaque quam cumque laborum aliquid esse?</p>
                                <button class="btn btn-warning text-dark">Read More</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card text-white text-center bg-dark pb-2">
                            <div class="card-body">
                                <i class="bi bi-person-hearts"></i>
                                <h3 class="card-title">Adoption and Foster Management </h3>
                                <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam reprehenderit odit quae! Ratione fugiat deserunt pariatur modi, iste, iusto sapiente necessitatibus ipsam recusandae consequuntur itaque quam cumque laborum aliquid esse?</p>
                                <button class="btn btn-warning text-dark">Read More</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card text-white text-center bg-dark pb-2">
                            <div class="card-body">
                                <!-- <i class="bi bi-cash-coin"></i> -->
                                <i class="bi bi-envelope-paper-heart-fill"></i>
                                <h3 class="card-title">Donations and Fundraising Management </h3>
                                <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam reprehenderit odit quae! Ratione fugiat deserunt pariatur modi, iste, iusto sapiente necessitatibus ipsam recusandae consequuntur itaque quam cumque laborum aliquid esse?</p>
                                <button class="btn btn-warning text-dark">Read More</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 col-md-12 col-lg-4">
                        <div class="card text-white text-center bg-dark pb-2">
                            <div class="card-body">
                                <i class="bi bi-cash-coin"></i>
                                <i class="bi bi-bag-heart-fill"></i>
                                <h3 class="card-title">Secaspi-Shop</h3>
                                <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam reprehenderit odit quae! Ratione fugiat deserunt pariatur modi, iste, iusto sapiente necessitatibus ipsam recusandae consequuntur itaque quam cumque laborum aliquid esse?</p>
                                <button class="btn btn-warning text-dark">Read More</button>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div> 
        </section>


     <!-- Animal Portfolio -->
     <section id="services" class="services section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Our Animals Profile</h2>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.<br> Numquam architecto consequatur accusantium quia nesciunt labore,<br> explicabo exercitationem esse est nisi iste, eos,<br> non praesentium magnam quidem. Odio iusto iste architecto?</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                            <div class="img-area mb-4">
                            <img src="3.jpeg" alt="" class="img-fluid">
                            </div>
                            <h3 class="card-title">Animal 1</h3>
                            <p class="lead">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam, error quos tenetur deleniti reiciendis qui mollitia! Rem, rerum fugit eveniet aut deserunt, ullam quis animi illo ab cum corporis delectus?</p>
                            <button class="btn bg-warning text-dark">See More</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                            <div class="img-area mb-4">
                            <img src="3.jpeg" alt="" class="img-fluid">
                            </div>
                            <h3 class="card-title">Animal 2</h3>
                            <p class="lead">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam, error quos tenetur deleniti reiciendis qui mollitia! Rem, rerum fugit eveniet aut deserunt, ullam quis animi illo ab cum corporis delectus?</p>
                            <button class="btn bg-warning text-dark">See More</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-white pb-2">
                        <div class="card-body text-dark">
                            <div class="img-area mb-4">
                            <img src="3.jpeg" alt="" class="img-fluid">
                            </div>
                            <h3 class="card-title">Animal 3</h3>
                            <p class="lead">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam, error quos tenetur deleniti reiciendis qui mollitia! Rem, rerum fugit eveniet aut deserunt, ullam quis animi illo ab cum corporis delectus?</p>
                            <button class="btn bg-warning text-dark">See More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     </section>

    <!-- Project -->
    <section id="project" class="project section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Program Project</h2>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.<br> Numquam architecto consequatur accusantium quia nesciunt labore,<br> explicabo exercitationem esse est nisi iste, eos,<br> non praesentium magnam quidem. Odio iusto iste architecto?</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="profile.png" alt="picture" class="img-fluid rounded-circle">
                            <h3 class="card-title">honey Jane</h3>
                           <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dicta dolor porro delectus suscipit a molestias velit earum. Esse quisquam similique quos autem sapiente suscipit obcaecati eos repellat provident quidem.
                           </p>
                           <p class="socials">
                           <i class="bi bi-facebook  text-dark"></i>
                           <i class="bi bi-twitter  text-dark"></i>
                           <i class="bi bi-messenger  text-dark"></i>
                           <i class="bi bi-instagram  text-dark"></i>
                           </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="profile.png" alt="picture" class="img-fluid rounded-circle">
                            <h3 class="card-title">honey Jane</h3>
                           <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dicta dolor porro delectus suscipit a molestias velit earum. Esse quisquam similique quos autem sapiente suscipit obcaecati eos repellat provident quidem.
                           </p>
                           <p class="socials">
                           <i class="bi bi-facebook  text-dark"></i>
                           <i class="bi bi-twitter  text-dark"></i>
                           <i class="bi bi-messenger  text-dark"></i>
                           <i class="bi bi-instagram  text-dark"></i>
                           </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="profile.png" alt="picture" class="img-fluid rounded-circle">
                            <h3 class="card-title">honey Jane</h3>
                           <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dicta dolor porro delectus suscipit a molestias velit earum. Esse quisquam similique quos autem sapiente suscipit obcaecati eos repellat provident quidem.
                           </p>
                           <p class="socials">
                           <i class="bi bi-facebook  text-dark"></i>
                           <i class="bi bi-twitter  text-dark"></i>
                           <i class="bi bi-messenger  text-dark"></i>
                           <i class="bi bi-instagram  text-dark"></i>
                           </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="profile.png" alt="picture" class="img-fluid rounded-circle">
                            <h3 class="card-title">honey Jane</h3>
                           <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dicta dolor porro delectus suscipit a molestias velit earum. Esse quisquam similique quos autem sapiente suscipit obcaecati eos repellat provident quidem.
                           </p>
                           <p class="socials">
                           <i class="bi bi-facebook  text-dark"></i>
                           <i class="bi bi-twitter  text-dark"></i>
                           <i class="bi bi-messenger  text-dark"></i>
                           <i class="bi bi-instagram  text-dark"></i>
                           </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--Contact Section -->
    <section id="contact" class="contact section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Contact Us</h2>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.<br> Numquam architecto consequatur accusantium quia nesciunt labore,<br> explicabo exercitationem esse est nisi iste, eos,<br> non praesentium magnam quidem. Odio iusto iste architecto?</p>
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <form action="#" class="bg-light p-4.m-auto">
                    <div class="col-md-12 p-0 pt-4 pb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" class="form-control" required placeholder="Your Full name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="email" class="form-control" required placeholder="Your Email name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                   <textarea rows="3" required class="form-control" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <button class="btn btn-warning btn-lg btn-block mt-3">Submit </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

        <div class="col-md-12 p-0 pt-4 pb-0">
                    <div class="map-area">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3868.074104644799!2d121.09248297494102!3d14.190437886248782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63bf9006e371%3A0x4fb03f5ad32d6acd!2sSECASPI%20(Second%20Chance%20Aspin%20Shelter%20Philippines)!5e0!3m2!1sen!2sph!4v1714310315607!5m2!1sen!2sph" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" ></iframe>
                    </div>
        </div>

    <!-- footer -->

    <footer class="bg-dark p-2 text-center"> 
        <div class="container">
            <p class="text-white">All Rights Reserved @FurEver Finder: Secaspi </p>
        </div>
    </footer>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
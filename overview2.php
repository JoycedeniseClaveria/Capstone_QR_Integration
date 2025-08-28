
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">

    <style>
        * {
    margin: 0;
    padding: 0;
    font-family:"Georgia";
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}
/* body {
    background: rgb(192, 101, 68);
} */
header {
    background:antiquewhite;
    width: 100%;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 50px;
    /* position: fixed; */
    
}
header .logo {
    font-size: 30px;
    text-transform:none;
    color: rgb(192, 101, 68);
}
header nav ul {
    display: flex;
}
header nav ul li a {
    display: inline-block;
    color: rgb(192, 101, 68);
    padding: 5px 0;
    margin: 0 10px;
    border: 3px solid transparent;
    text-transform: uppercase;
    transition: 0.5s;
    text-decoration: none;
}
header nav ul li a:hover{
/* header nav ul li a.active { */
    border-bottom-color: rgb(255, 68, 0);
}
.hamburger {
    cursor: pointer;
    display: none;
}
.hamburger div {
    width: 30px;
    height: 3px;
    margin: 5px 0;
    background: rgb(192, 101, 68);
}
@media only screen and (max-width: 900px) {
    header {
        padding: 0 30px;
    }
    
}
@media only screen and (max-width: 700px) {
    .hamburger {
        display: block;
    }
    header nav {
        position: absolute;
        width: 100%;
        left: -100%;
        top: 70px;
        width: 100%;
        background: antiquewhite;
        padding: 30px;
        transition: 0.5s;
    }
    header #nav_check:checked ~ nav {
        left: 0;
    }
    header nav ul {
        display: block;
    }
    header nav ul li a {
        margin: 5px 0;
    }
    @media screen and (max-width: 768px) {
        .section {
            /* width: 90%; */
            height:80%;
            /* Adjust styles for smaller screens */
        }
    }
}

/* ------------------pages------------------ */
section{
    height: 100vh;
    display: flex;
    justify-content: center; 
    align-items: center;
    color: antiquewhite;
    scroll-snap-align: start;
    
}

.bgpar1{
    background:url(bg11.png);
    height: 100vh;
    padding: 100px 0;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    
}
.bgpar1 h1{
font-family: "Abril Fatface", serif;
font-weight: 400;
font-style: normal;
color: rgb(192, 101, 68);
}

.bgpar2 h1{
    font-family: "Abril Fatface", serif;
    font-weight: 300;
    font-size: 30px;
    font-style: normal;
    color: rgb(247, 245, 245);
    padding: 2rem;
    
    }
.bgpar2 .card-body{
    background: rgb(192, 101, 68);
    
    
}
.btn-primary:hover {
    color: #fff;
    background-color: antiquewhite;;
    border-color:  rgb(192, 101, 68);
}
/* .container{
    scroll-snap-type: y mandatory;
    overflow-y: scroll;
    height: 100vh;
} */
/* #one{
    /* background: rgb(192, 101, 68); */
  
/* } */ 
#two {
    background: rgb(192, 101, 68);
}
#three{
    background:rgb(209, 164, 147);
}
#four{
background:antiquewhite;
}
#five{
    background:rgb(192, 101, 68);
}
.image1{
  align-content: space-between;
}
.card-about {
    width: 440px;
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s ease;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
}


.card-about:hover {
    transform: scale(1.05); 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
}
.card{
    background-color:white;
     margin: 20px;
     color: antiquewhite;
     border-color: bisque;
     border: 10px solid;
     border-radius: 20px;


    
    
}
.card-body{
    background-color:rgb(192, 101, 68);
}
/* .course{
    width: 80%;
    margin: auto;
    text-align: center;
    padding-top:100px ;
}
h1{
    font-size: 36px;
    font-weight: 600px;
    
}

p{
    color:#0f0f0f;
    font-size: 300;
    line-height: 22px;
    padding: 10px;

} */
/* --------------css section three-------------- */
.card .btn-primary {
    color: rgb(192, 101, 68) ;
    background-color:antiquewhite;
    border-color: rgb(192, 101, 68);
}
/* ------------------footer---------------- */
/* .bg-white{
    padding: 35px;
    background-color: antiquewhite;
    color: rgb(192, 101, 68);
    text-align: center;
} */
.footer{
    height: 50px;
    width: 100%;
 
    padding: 30px 0;
    background-color: antiquewhite;
}
.footer h4{
    margin-bottom: 25px;
    margin-top: 20px;
    font-weight: 60;
    text-align: center;
    color:rgb(192, 101, 68) ;
}

    </style>

</head>
<body>
    <header>
        <div class="logo">FurEver Finder</div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <ul>
                <li>
                    <a href="#one" class="active">Home</a>
                </li>
                <li>
                    <a href="#two">About Us</a>
                </li>
                <li>
                    <a href="#three">Portfolio</a>
                </li>
                <li>
                    <a href="#four">Services</a>
                </li>
                <li>
                    <a href="#five">Contact</a>
                </li>
            </ul>
        </nav>

    
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>

  
        <section id="one" class="bgpar1">
            <h1>"Welcome to Animal Secaspi"</h1>
            <!-- <div class="img1"></div>
                <img src="homapage.png" alt="Animal" width="500%" height="400px" >
            </div> -->
        </section>

        <section id="two" class="bgpar2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1>About Us</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem accusantium omnis dolor eaque error culpa reiciendis architecto consequatur, aperiam, libero ullam. Facere natus, ratione vero repellendus hic ea cupiditate obcaecati.
                        Officiis odit iure quae nulla tempora assumenda odio atque eum reiciendis nemo, vel incidunt quo ipsum, rerum adipisci exercitationem. Nihil, fuga aspernatur? Explicabo provident est eius, maiores veritatis facilis alias?</p>
                    </div>
                    <div class="col-md-6">
                        <div class="card-about">
                            <img src="1.png" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <a href="#" class="btn btn-primary">Learn More</a> 
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <section id="three">
            <div class="card" style="width: 18rem;">
                <img src="download.png" class="card-img-top" alt="Animal">
                <div class="card-body">
                  <h5 class="card-title"> Animal Portfolio</h5>
                  <p class="card-text">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident."</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="download.png" class="card-img-top" alt="Animal">
                <div class="card-body">
                  <h5 class="card-title">Animal Portfolio</h5>
                  <p class="card-text">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident."</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="download.png" class="card-img-top" alt="Animal">
                <div class="card-body">
                  <h5 class="card-title">Animal Portfolio</h5>
                  <p class="card-text">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident."</p>
                  <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
            
        </section>

        <section id="four">
            <div class="card" style="width: 18rem;">
                <img src="download.png" class="card-img-top" alt="Animal">
                <div class="card-body">
                  <h5 class="card-title"> intake </h5>
                  <p class="card-text">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident."</p>
                  <a href="#" class="btn btn-primary">Click Here</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="download.png" class="card-img-top" alt="Animal">
                <div class="card-body">
                  <h5 class="card-title">Adoption and Foster</h5>
                  <p class="card-text">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident."</p>
                  <a href="#" class="btn btn-primary">Click Here</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="download.png" class="card-img-top" alt="Animal">
                <div class="card-body">
                  <h5 class="card-title">Donations and Fundraising</h5>
                  <p class="card-text">"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident."</p>
                  <a href="#" class="btn btn-primary">Click Here</a>
                </div>
            </div>
            
        </section>

        <section id="five">
            <div class="container">
                <h1>Contact Us</h1>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>

        <section class="footer" >
         <h4>© 2024 FurFinder - Secaspi Animal Shelter</h4>
        </footer>






     <script>
        hamburger = document.querySelector(".hamburger");
        hamburger.onclick = function(){
            navBar = document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }
     </script>



</body>
</html>
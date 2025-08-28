<?php
    session_start();
    include 'connection.php';

    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header('location: loginV2.php');
        exit(); // Ensure to exit after redirection
    } 

    // Retrieve user information from session
    $userId = $_SESSION['userId'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Page</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: "Lato", sans-serif;
            margin: 0px;
            overflow-x: hidden; /* Disable vertical scrolling */
        }

        .sidepanel {
            width: 0; 
            position: fixed;
            z-index: 1;
            height: 100vh;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidepanel a {
            padding: 8px 8px 8px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: block;
            transition: 0.3s;
            text-align: center;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel a.active {
            background-color: yellow; /* Change to desired active link background color */
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
        }

        .openbtn {
            /* font-size: 20px;
            cursor: pointer;
            background-color: black;
            color: white;
            padding: 15px 15px 15px;
            margin: 0px;
            border: none;
            height: 8vh; */
            /* width: 100%; */
            font-size: 20px;
            cursor: pointer;
            background-color: black;
            color: white;
            padding: 15px; 
            margin: 0;
            border: none;
            height: 8vh; 
            position: fixed;
            top: 0; 
            left: 0; 
            display: inline-block;
            z-index: 1;
            /* transition: transform 0.3s ease;  */
        }

        .openbtn:hover {
            background-color: #444;
        }

        .header {
            width: 100%;
            background-color: black;
            height: 8vh;
            display: flex;
            position: fixed;
            justify-content: flex-end; /* Aligns children to the right */            
            box-sizing: border-box; 
        }

        @media (min-width: 576px) {
            #animalCardsRow.card-columns {
                column-count: 2;
            }
        }

        @media (min-width: 768px) {
            #animalCardsRow.card-columns {
                column-count: 3;
            }
        }

        @media (min-width: 992px) {
            #animalCardsRow.card-columns {
                column-count: 5;
            }
        }

    
        /* Set max-height for scrollable container */
        .scrollable-container {
            overflow-y: auto;
            margin-top: 115px;
            max-height: 80vh;
        }

        .scrollable-container::-webkit-scrollbar {
            display: none;
        }

        /* Optional: Adjust card spacing */
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 8px 16px 24px rgba(0, 0, 0, 0.2); 
        }

        /* Optional: Increase card title font size for smaller screens */
        @media (max-width: 576px) {
            .card-title {
                font-size: 1.2rem;
            }
        }

        @media (min-width: 992px) { 
            .col-lg-2 {
                flex: 0 0 20%; 
                max-width: 20%; 
            }
        }

        /* CSS styles for spinner overlay */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            background-color: rgba(151, 151, 151, 0.3);
        }

        /* Spinner styles */
        .spinner-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .spinner-border {
            width: 4rem;
            height: 4rem;
            color: black;
            border-width: 0.3em;
        }

        .btn7 {
            font-size: 16px;
        }

        .filterG {
            margin-top: 40px;
        }

        .cardG {
            margin-top: 20px;
        }
       

    </style>
</head>
<body>

    <div id="mySidepanel" class="sidepanel">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="dashboard.php" onclick="setActiveLink(this)">Home</a>
        <a href="adoptionPage.php" onclick="setActiveLink(this)">Adopt</a>
        <a href="#" onclick="setActiveLink(this)">Clients</a>
        <a href="#" onclick="setActiveLink(this)">Contact</a>
    </div>

    <div class="header">
        <button class="openbtn" onclick="toggleNav()">☰</button>
    </div>

    <!-- Toggle Button -->
        <button class="" onclick="toggleView()">Toggle View</button>
    
    <!-- filter -->
    <div class="container-fluid filterG">
        <div class="row">
            <div class="col-md-4 mb-3">
                <select class="form-control rounded btn7" style="width: 50%; height: 4.5vh;" name="species" id="speciesFilter" onchange="updateTotalCardsCount()">
                    <option value="" disabled selected></option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <select class="form-control rounded btn7" style="width: 50%; height: 4.5vh;" name="status" id="statusFilter" onchange="updateTotalCardsCount()">
                    <option value="" disabled selected></option>
                    <option value="Adoptable">Adoptable</option>
                    <option value="In Foster">In Foster</option>
                    <option value="Pending">Pending</option>
                    <option value="Adopted">Adopted</option>
                    <option value="Medical Hold">Medical Hold</option>
                    <option value="Escaped/Lost">Escaped/Lost</option>
                    <option value="Pending Adoption">Pending Adoption</option>
                    <option value="Pending Transfer">Pending Transfer</option>
                </select>
            </div>

            <div class="col-md-2 mb-3">
                <button class="btn btn-primary btn-block" style="width: 20%; height: 4.5vh;" id="searchButton" onclick="handleSearch()">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="col-md-2 mb-3">
                <button class="btn btn-secondary btn-block" style="width: 20%; height: 4.5vh;" id="refreshButton" onclick="handleRefresh()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            <div class="col-md-2">
                <p>Total: <span id="totalCount">0</span></p>
            </div>
        </div>
    </div>

    <!-- end of filter -->

    <!-- Spinner Overlay -->
    <div id="preloader">
        <div class="spinner-container text-primary">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

  <!-- Button to trigger spinner
  <button id="color-btn" onclick="showSpinner()">
    Click Me
  </button> -->

    <!-- load cards -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="scrollable-container cardG">
                    <div class="row" id="animalCardsRow">
                        <!-- Animal cards will be loaded dynamically here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
        // Load animal cards initially when the page is ready
        loadAnimalCards();

        // Function to load animal cards based on selected filters
        function loadAnimalCards() {
            showSpinner();
            var selectedSpecies = $('#speciesFilter').val();
            var selectedStatus = $('#statusFilter').val();

            $.ajax({
                url: 'loadCards.php',
                type: 'GET',
                data: { species: selectedSpecies, status: selectedStatus },
                success: function(response) {
                    var cardsRow = $('#animalCardsRow');
                    cardsRow.empty(); // Clear existing cards
                    $(response).each(function(index, cardHtml) {
                        // Create a column div for each card and append to the row
                        var colDiv = $('<div>')
                            .addClass('col-12 col-sm-6 col-md-4 col-lg-3 mb-4') // Adjust mb-4 for margin-bottom spacing
                            .html(cardHtml)
                            .attr('data-species', selectedSpecies) // Set data attributes for species and status
                            .attr('data-status', selectedStatus);
                        cardsRow.append(colDiv);
                    });

                    // Update total card count after loading cards
                    updateTotalCardsCount();
                },
                complete: function() {
                    hideSpinner(); // Hide spinner after request completes
                },
                error: function() {
                    $('#animalCardsRow').html('<p class="text-danger">Error loading animal cards.</p>');
                    hideSpinner(); // Hide spinner on error
                }
            });
        }

        // Function to update total card count based on current filters
        function updateTotalCardsCount() {
            var totalCount = $('#animalCardsRow').children().length;
            $('#totalCount').text(totalCount);
        }


        // Listen for click event on the search button
        // $('#searchButton').click(function() {
        //     loadAnimalCards(); // Reload cards based on current filters
        // });

        // // Listen for click event on the refresh button
        // $('#refreshButton').click(function() {
        //     $('#speciesFilter').val(''); // Clear species filter
        //     $('#statusFilter').val(''); // Clear status filter
        //     loadAnimalCards(); // Reload cards without filters
        // });

        // Listen for change event on the filter selects
        $('#speciesFilter, #statusFilter').change(function() {
            loadAnimalCards(); // Reload cards based on current filters
        });

        // Clear filters and reload cards on refresh button click
        $('#refreshButton').click(function() {
            $('#speciesFilter, #statusFilter').val(''); // Clear filters
            loadAnimalCards(); // Reload cards without filters
        });
    });


        function toggleNav() {
            var sidePanel = document.getElementById("mySidepanel");
            if (sidePanel.style.width === "250px") {
                sidePanel.style.width = "0";
            } else {
                sidePanel.style.width = "250px";
            }
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        function setActiveLink(clickedLink) {
            // Add active class to the clicked link
            var links = document.getElementsByTagName("a");
            for (var i = 0; i < links.length; i++) {
                links[i].classList.remove("active");
            }
            clickedLink.classList.add("active");
        }

        // Set active link when the page loads
        window.onload = function () {
            var currentUrl = window.location.href;
            var links = document.getElementsByTagName("a");

            for (var i = 0; i < links.length; i++) {
                if (links[i].href === currentUrl) {
                    links[i].classList.add("active");
                    break; // Stop after finding the current link
                }
            }
            
        };

        function showSpinner() {
        $('#preloader').css('display', 'block');
        }

        function hideSpinner() {
            $('#preloader').css('display', 'none');
        }



        
    </script>
</body>
</html>

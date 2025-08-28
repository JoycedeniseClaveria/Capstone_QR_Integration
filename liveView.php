<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 15%;
            padding: 20px;
            overflow-y: auto; /* Enable vertical scrollbar */
            max-height: calc(100vh - 40px); 
        }

        .sidebar button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            border: 1px solid black;
            background-color: white;
            cursor: pointer;
            font-weight: bold;
            /* transition: background-color 0.3s ease; Smooth transition for background color change */
        }

        .sidebar button.active {
            background-color: #1E0342; /* Change background color when button is active */
            color: white; /* Change text color for active button */
            font-weight: bold;
        }

        /* .sidebar button:hover {
            background-color: #ededed; 
            color: black;
            font-weight: bold;
        } */

        .content {
            flex: 1;
            padding: 0px;
            border: 2px solid black;
            margin: 20px;
            margin-bottom: 70px;
            background-color: white;
        }

        .redirect-button {
            position: absolute;
            left: 21%;
            top: 90%;
            transform: translateX(-50%); /* Adjust for center alignment */
            width: 70px;
            padding: 10px;
            margin: 20px auto;
            text-align: center;
            border: 1px solid #1E0342;
            background-color: #1E0342;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border-radius: 5px;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .redirect-button:hover {
            background-color: #ededed;
            color: black;
        }

         /*ipad landscape*/
         @media only screen and (min-width:1024px) and (max-width: 1138px) {
            .redirect-button {
                left: 26.5%;
                top: 85%;
            }

            .sidebar {
                width: 18%;
                padding: 20px;
                overflow-y: auto; /* Enable vertical scrollbar */
                max-height: calc(100vh - 40px); 
            }

            .sidebar button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                text-align: center;
                border: 1px solid black;
                background-color: white;
                cursor: pointer;
                font-weight: bold;
                /* transition: background-color 0.3s ease; Smooth transition for background color change */
            }
         }

         /* mobile landscape */
         @media only screen and (min-device-width: 480px) 
            and (max-device-width: 915px) 
            and (orientation: landscape) {
                .redirect-button {
                left: 30%;
                top: 90%;
            }

            .sidebar {
                width: 18%;
                padding: 20px;
                overflow-y: auto; /* Enable vertical scrollbar */
                max-height: calc(100vh - 40px); 
            }

            .sidebar button {
                display: block;
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                text-align: center;
                border: 1px solid black;
                background-color: white;
                cursor: pointer;
                font-weight: bold;
                /* transition: background-color 0.3s ease; Smooth transition for background color change */
            }

               
        }



    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <button data-page="cam1" onclick="showContent('cam1')" class="active">WAREHOUSE</button>
            <button data-page="cam2" onclick="showContent('cam2')">ENGINEERING</button>
            <button data-page="cam3" onclick="showContent('cam3')">ADMIN</button>
            <button data-page="cam4" onclick="showContent('cam4')">GUARD 1</button>
            <button data-page="cam5" onclick="showContent('cam5')">WT-PAINTING</button>
            <button data-page="cam6" onclick="showContent('cam6')">LOADING</button>
            <button data-page="cam7" onclick="showContent('cam7')">FLAG POLE</button>
            <button data-page="cam8" onclick="showContent('cam8')">Camera 8</button>
            <button data-page="cam9" onclick="showContent('cam9')">Camera 9</button>
            <button data-page="cam10" onclick="showContent('cam10')">Camera 10</button>
            <button data-page="cam11" onclick="showContent('cam11')">Camera 11</button>
            <button data-page="cam12" onclick="showContent('cam12')">Camera 12</button>
            <button data-page="cam13" onclick="showContent('cam13')">Camera 13</button>
            <button data-page="cam14" onclick="showContent('cam14')">Camera 14</button>
            <button data-page="cam15" onclick="showContent('cam15')">Camera 15</button>
            <button data-page="cam16" onclick="showContent('cam16')">Camera 16</button>
        </div>
        <div class="content" id="content">
            <!-- Content will be dynamically loaded here -->
        </div>
    </div>

    <button class="redirect-button" onclick="goToAnotherPage()"> H </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Load default content on page load
            showContent('cam1');
        });

        function showContent(page) {
            const contentDiv = document.getElementById('content');
            const buttons = document.querySelectorAll('.sidebar button');

            // Reset all button styles
            buttons.forEach(button => {
                button.classList.remove('active');
            });

            // Apply 'active' class to the clicked button
            const clickedButton = document.querySelector(`button[data-page="${page}"]`);
            if (clickedButton) {
                clickedButton.classList.add('active');
            }

            switch (page) {
            default:
            case 'cam1':
                contentDiv.innerHTML = `
                    <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_129/"></iframe>
                `;
                break;
            case 'cam2':
                contentDiv.innerHTML = `
                    <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_123/"></iframe>
                `;
                break;
            case 'cam3':
                contentDiv.innerHTML = `
                    <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_149/"></iframe>
                `;
                break;
            case 'cam4':
                contentDiv.innerHTML = `
                    <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_131/"></iframe>
                `;
                break;
            case 'cam5':
                contentDiv.innerHTML = `
                <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_133/"></iframe>
                `;
                break;
            case 'cam6':
                contentDiv.innerHTML = `
                <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_134/"></iframe>
                `;
                break;
            case 'cam7': 
                contentDiv.innerHTML = `
                <iframe width="100%" height="100%" src="http://209.146.30.122/livestream/video/camera_135/"></iframe>
                `;
                break;
            case 'cam8':
                contentDiv.innerHTML = `
                    <center><h2>Camera 8</h2></center>
                `;
                break;
            case 'cam9':
                contentDiv.innerHTML = `
                    <center><h2>Camera 9</h2></center>
                `;
                break;
            case 'cam10':
                contentDiv.innerHTML = `
                    <center><h2>Camera 10</h2></center>
                `;
                break;
            case 'cam11':
                contentDiv.innerHTML = `
                    <center><h2>Camera 11</h2></center>
                `;
                break;
            case 'cam12':
                contentDiv.innerHTML = `
                    <center><h2>Camera 12</h2></center>
                `;
                break;
            case 'cam13':
                contentDiv.innerHTML = `
                    <center><h2>Camera 13</h2></center>
                `;
                break;
            case 'cam14':
                contentDiv.innerHTML = `
                    <center><h2>Camera 14</h2></center>
                `;
                break;
            case 'cam15':
                contentDiv.innerHTML = `
                    <center><h2>Camera 15</h2></center>
                `;
                break;
            case 'cam16':
                contentDiv.innerHTML = `
                    <center><h2>Camera 16</h2></center>
                `;
                break;
            // default:
            //     contentDiv.innerHTML = `
            //         <center><h2>Welcome!</h2></center>
            //     `;
            //     break;
            }
        }

        function goToAnotherPage() {
            // Redirect to another page
            window.location.href = 'history.php';
        }
    </script>
</body>
</html>
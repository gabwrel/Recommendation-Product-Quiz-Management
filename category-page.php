<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/output.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: clamp(70px, 2vw, 120px);
            font-weight: bold;
            letter-spacing: 6px;    
            margin-top: -20px;  
            margin-bottom: -20px;
        }

        h3 {
            font-size: clamp(30px, 2vw, 70px);
            font-weight: bold;
            color: #8E7242;
        }

        p {
            color: #8E7242;
            font-size: clamp(14px, 2vw, 18px);
        }

        .custom-bg {
            background-image: url('./assets/images/bg-2.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content {
            text-align: center;
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: auto;
            height: -webkit-fill-available;
            padding: 50px;
            justify-content: center;
        }

        .wrapper{
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: space-around;
            align-items: center;
            height: 600px;
        }

        .choices {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            background-image: linear-gradient(to right, #2A68DC 0%, #4DA3FF 37%, #3677E4 100%);
        }

        .choices:hover {
            transition: all 0.5s ease 0s;
            background: #FFF;
        }

        button {
            width: clamp(200px, 50vw, 350px);
            height: clamp(35px, 5vh, 50px);
            font-size: clamp(16px, 2vw, 22px);
            border-color: #8E7242;
        }

        button:hover {
            transition: all 1s ease 0s;
            color: #8E7242;
            background: #fff;
        }


        .description{
            width: clamp(260px, 80vw, 550px);
        }

    </style>
</head>

<body>
    <?php
        $pageTitle = "Quiz";
        session_start();
        if (!isset($_SESSION['selectedCategory'])) {
            header('Location: index.php');
            exit();
        }
        // include 'header.php';
        include 'db.php';
        $selectedCategory = $_SESSION['selectedCategory'];

        $query = "SELECT * FROM category WHERE categoryID = '$selectedCategory'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $categoryDescription    = $row['categoryDescription'];
            $categoryName           = $row['categoryName'];
    ?>
    <div class="custom-bg">
        <div class="content">
            <div class="wrapper">
                <div class="text">
                    <h3>READY FOR A</h3>
                    <h1>QUIZ?</h1>
                    <h3><?php echo $categoryName; ?></h3>
                    <br>
                    <div class="description">
                        <p><?php echo $categoryDescription;?></p>
                    </div>
                </div>
                <div class="buttons">
                    <button onclick="location.href='quiz.php'" class="choices text-white border-2 rounded-3xl px-auto py-auto text-center me-2 mb-2">Click to start</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    }
    ?>
</body>
</html>
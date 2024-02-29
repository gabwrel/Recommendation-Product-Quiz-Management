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
        }

        .custom-bg {
            background-image: url('./assets/images/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .content{
            text-align: center;
            display: flex;
            flex-direction: column; 
            align-items: center;
            max-width: 400px;
            margin: auto;
            height: -webkit-fill-available;
            justify-content: space-between;
            padding: 50px;
        }
        
        .wrapper{
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: space-between;
            align-items: center;
            height: 600px;
        }

        .title {
            text-align: center;
            font-size: clamp(20px, 5vw, 28px);
            font-weight: bold;
            color: #8E7242;
        }

        .buttons {
            height: 100%;
            width: 100%;
        }

        .choices {
            margin-bottom: clamp(25px, 2vw, 40px);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            background-image: linear-gradient(to right, #2A68DC 0%, #4DA3FF 37%, #3677E4 100%);
        }


        .choices:hover {
            transition: all 0.5s ease 0s;
            background: #FFF;
        }

        button {
            display: block;
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

        .spacer {
            height: 10vh;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $pageTitle = "Quiz";
    // include 'header.php';
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['selectedCategory'] = $_POST['category'];
        header("Location: category-page.php");
        exit();
    }

    ?>

    <div class="custom-bg">
        <div class="content">
            <div class="wrapper">
                <div class="title">Solutions you're<br>looking for</div>
                <div class="selection">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="post">
                        <?php
                        $categoryQuery = "SELECT * FROM category";
                        $categoryResult = mysqli_query($conn, $categoryQuery);
                        
                        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                            $categoryID = $categoryRow['categoryID'];
                            $categoryName = $categoryRow['categoryName'];
                            ?>
                            <div class="buttons">
                                <button type="submit" class="choices text-white border-2 rounded-3xl px-auto py-auto text-center me-2 mb-2" name="category" value="<?php echo $categoryID; ?>">
                                    <?php echo $categoryName; ?>
                                </button>
                            </div>
                            <?php
                        }
                        ?>
                    </form>
                </div>
                <div class="spacer"></div>
            </div>
        </div>
    </div>
</body>

</html>

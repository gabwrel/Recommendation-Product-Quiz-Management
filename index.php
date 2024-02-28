    <?php
    session_start();
    $pageTitle = "Quiz";
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['selectedCategory'] = $_POST['category'];
        header("Location: category-page.php");
        exit();
    }
    ?>

    <link rel="stylesheet" href="./assets/output.css">


    <div class="custom-bg flex flex-col h-screen justify-between">
        <div class="text-center">
            <h1 class="title text-4xl font-bold text-center">Solutions you're<br>looking for</h1>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="post">

        <div class="flex flex-col items-center space-y-4">
            <?php
                $categoryQuery = "SELECT * FROM category";
                $categoryResult = mysqli_query($conn, $categoryQuery);

                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                    $categoryID     = $categoryRow['categoryID'];
                    $categoryName   = $categoryRow['categoryName'];
                    ?>
                    <div class="buttons">
                        <button type="submit" class="text-white text-2xl bg-gradient-to-r from-bc1 via-bc2 to-bc3 border-amber-700 border-2 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 rounded-3xl text-sm px-5 py-2.5 text-center me-2 mb-2" name="category" value="<?php echo $categoryID; ?>">
                            <?php echo $categoryName; ?>
                        </button>
                    </div>
                    <?php
                }
            ?>
        </div>
        </form>
        <div class="bottom-space">
        </div>
    </div>

    <style>
        .title{
        }

        .bottom-space{
            height: 300px;
        }

        .buttons { 
            max-width: 360px;
            min-width: 200px;
            width: 100%;
        }

        button{
            display: block;
            width: 100%;
            z-index: 10;
        }


        .custom-bg {
            background-image: url('./assets/images/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            width: 100%;
            height: 100vh;
            margin: 0;
            min-width: 360px !important;
            min-height: 800px !important; 
            padding-top: clamp(20px, 40%, 40px);
        }

    </style>


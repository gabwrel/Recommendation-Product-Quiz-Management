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

<script src="https://cdn.tailwindcss.com"></script>

<div class="custom-bg flex items-center justify-center h-full">
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="post">
            <div class="container">
                <h1 class="text-lg mobile:text-xl lg:text-2xl font-bold pt-10">Solutions you're<br>looking for</h1>
            </div>

            <div class="container">
                <?php
                $categoryQuery = "SELECT * FROM category";
                $categoryResult = mysqli_query($conn, $categoryQuery);

                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                    $categoryID     = $categoryRow['categoryID'];
                    $categoryName   = $categoryRow['categoryName'];
                    ?>
                    <div class="mb-4">
                        <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-8 py-2.5 mb-2" name="category" value="<?php echo $categoryID; ?>">
                            <?php echo $categoryName; ?>
                        </button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </form>
    </div>
</div>

<style>

    .mb-4 { 
        max-width: 350px;
        min-width: 200PX;
        width: 100%;
    }

    button{
        display: block;
        width: 100%;
    }

    .custom-bg {
        background-image: url('./assets/images/bg-1.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        width: 100%;
        height: 100vh; /* Set the height of the body to fill the viewport */
        margin: 0; /* Remove default margin */
    }
</style>

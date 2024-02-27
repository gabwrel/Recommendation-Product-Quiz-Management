<?php
    $pageTitle = "Quiz";
    session_start();
    if (!isset($_SESSION['selectedCategory'])) {
        header('Location: index.php');
        exit();
    }
    include 'header.php';
    include 'db.php';
    $selectedCategory = $_SESSION['selectedCategory'];

    $query = "SELECT * FROM category WHERE categoryID = '$selectedCategory'";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
        $categoryDescription    = $row['categoryDescription'];
        $categoryName           = $row['categoryName'];
?>
<style>
    .container{
        margin-top: 10em;
    }
</style>
<div class="container text-center w-75">
    <div class="container">
        <h3>READY FOR A</h3>
        <h1>QUIZ?</h1>
    </div>

    <div class="container">
        <small><?php echo $categoryName; ?></small>
    </div>

    <div class="container">
        <p><?php echo $categoryDescription;?></p>
    </div>

    <div class="container">
        <a href="quiz.php" class="btn btn-primary rounded-pill">Click to start</a>
    </div>
</div>

<?php
 }
?>
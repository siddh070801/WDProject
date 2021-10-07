<?php include "database.php" ?>
<?php if(isset($_GET["rec_id"])){
    $rec_id=$_GET["rec_id"];
    $ci_query=$conn->prepare("DELETE FROM `records` WHERE `id` = :id");
    $ci_execution=$ci_query->execute([
        'id' => $rec_id
    ]);
    if($ci_execution){
        header("Location: index.php");
        die();
    }
}
?>
<?php include "includes/header.php" ?>

<div class="container">

</div>
<?php include "includes/footer.php" ?>
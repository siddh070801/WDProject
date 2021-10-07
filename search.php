<?php include "database.php" ?>

<?php include "includes/header.php" ?>
<div class="row flex-row-reverse mr-3 pt-2">
    <a href="add_record.php"><button class="btn btn-primary">Add New Record</button></a>
</div>
<div class="container pt-4">
<div class="row">
<?php 
$query = $_GET['q'];
$records_query=$conn->prepare("SELECT * FROM records where `name` LIKE '%".$query."%'");
$records_query->execute();
$rows=$records_query->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows);
foreach ($rows as $row) {
    echo '<div class="recordd ml-4 mb-4" style="width: 18rem;">
    <img class="recordd-img-top" src="assets/img/'.$row['image'].'" width="300px" height="300px" alt="Recordd image cap">
    <div class="recordd-body">
        <h5 class="recordd-title">'.$row["name"].'</h5>
        <p class="recordd-text">'.$row["email"].'</p>
        <p class="recordd-text">'.$row["phone"].'</p>
        <div class="row justify-content-between px-2">
            <a href="edit_record.php?record_id='.$row["id"].'"><button class="btn btn-warning">Edit</button></a>
            <a href="delete_record.php?record_id='.$row["id"].'"><button class="btn btn-danger">Delete</button></a>
        </div>
    </div>
    </div>';
}

?>

<?php include "includes/footer.php" ?>
<?php include "database.php" ?>

<?php
if(isset($_GET["record_id"])){
    $record_id=$_GET["record_id"];
    $records_query=$conn->prepare("SELECT * FROM records where `id` = :id");
    $records_query->execute([
        'id' => $record_id
    ]);
    $rows=$records_query->fetchAll(PDO::FETCH_ASSOC);
    $row=$rows[0];
}
if(!empty($_FILES)) {
    $name=$_POST["name"];
    $model=$_POST["model"];
    $description=$_POST["description"];
    $rec_image_name=htmlspecialchars( basename( $_FILES["rec_image"]["name"]));
    // echo $name.'<br>';
    // echo $model.'<br>';
    // echo $description.'<br>';
    // echo $rec_image_name.'<br>';

    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($_FILES["rec_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["rec_image"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["rec_image"]["size"] > 500000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["rec_image"]["tmp_name"], $target_file)) {
        //echo "The file ". htmlspecialchars( basename( $_FILES["rec_image"]["name"])). " has been uploaded.";
    }
    }
    $ci_query=$conn->prepare("UPDATE `records` SET `name` = :name, `email` = :email, `phone` = :phone, `image` = :rec_image_name WHERE `id` = :id");
    $ci_execution=$ci_query->execute([
        'name' => $name,
        'model' => $model,
        'rec_image_name' => $rec_image_name,
        'description' => $description,
        'id' => $rec_id
    ]);
    if($ci_execution){
        echo "Record Edited Successfully";

        header("Location: index.php");
        die();
    }
}
?>
<?php include "includes/header.php" ?>

<div class="container pt-4">
<form method="POST" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Name</label>
      <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" id="name" placeholder="Name">
    </div>
    <div class="form-group col-md-6">
      <label for="model">Email</label>
      <input type="text" class="form-control" name="model" value="<?php echo $row['email']; ?>" id="email" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="description">Phone</label>
    <input type="text" class="form-control" name="description" value="<?php echo $row['phone']; ?>" id="phone" placeholder="Phone">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Image</label>
    <input type="file" class="form-control" name="rec_image" id="image">
  </div>
  <button type="submit" value="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<?php include "includes/footer.php" ?>
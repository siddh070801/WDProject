<?php include "database.php" ?>
<?php
if(!empty($_FILES)) {
    $name=$_POST["name"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $rec_image_name=htmlspecialchars( basename( $_FILES["rec_image"]["name"]));

    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($_FILES["rec_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
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

    if (file_exists($target_file)) {
    $uploadOk = 0;
    }

    if ($_FILES["rec_image"]["size"] > 500000) {
    $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $uploadOk = 0;
    }

    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    } else {
    if (move_uploaded_file($_FILES["rec_image"]["tmp_name"], $target_file)) {
    }
    }
    $ci_query=$conn->prepare("INSERT INTO `records` (`name`, `email`, `phone`, `image`) VALUES (:name, :email, :phone, :rec_image_name)");
    $ci_execution=$ci_query->execute([
        'name' => $name,
        'email' => $email,
        'rec_image_name' => $rec_image_name,
        'phone' => $phone
    ]);
    if($ci_execution){
      header("Location: index.php");
    }
}
?>
<?php include "includes/header.php" ?>

<div class="container pt-4">
<form method="POST" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Name</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Name">
    </div>
    <div class="form-group col-md-6">
      <label for="model">Email</label>
      <input type="text" class="form-control" name="email" id="email" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="description">Phone</label>
    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Image</label>
    <input type="file" class="form-control" name="rec_image" id="image">
  </div>
  <button type="submit" value="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<?php include "includes/footer.php" ?>
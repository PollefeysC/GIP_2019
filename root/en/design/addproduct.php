<form method="POST" enctype="multipart/form-data" id="addproduct" class='admin' name='add'>
        <h2>Add product</h2>
            <h4>Product name:</h4>
            <input type="text" name="name" placeholder="Product name">


            <h4>Price:</h4>
            <input type="text" name="price" placeholder="Product price">
        
        
            <h4>Description:</h4>
            <textarea name="description" placeholder="Product description"></textarea>
        
        
            <h4>Product image:</h4>
            <input type="file" name="fileToUpload">
        
        
            <h4>Product Category:</h4>
            <div><input type="radio" name="category" value="1"> Shorts</div>
            <div><input type="radio" name="category" value="2"> Shirts</div>
            <div><input type="radio" name="category" value="3"> Balls</div>
            <div><input type="radio" name="category" value="4"> Rackets</div>
            <div><input type="radio" name="category" value="5"> Bags</div>
            <div><input type="radio" name="category" value="6"> Shoes</div>
            <input type="submit" name="submitAddProduct" id="addproduct" value="Submit"> 
</form>

<?php 
if (isset($_POST["submitAddProduct"]) && isset($_FILES['fileToUpload'])) {

    $target_dir = "../img_products/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $endMsg = "";

    $fileName = basename($_FILES["fileToUpload"]["name"]);
    
    if (isset($_POST["submitAddProduct"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
           $uploadOk = 1;
        } else {
           $uploadOk = 0;
        }
   }

    if (file_exists($target_file)) {
        $endMsg = "Het bestand bestaat al!";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"]> 5000000) {
        $endMsg = "Het bestand is: ".$_FILES["fileToUpload"]["size"]." bites groot, 500000 bites is de limiet!";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $endMsg = "Enkel JPG, PNG, JPEG, GIF zijn toegelaten, sorry";
    }

    if ($uploadOk == 0) {
        //echo "U bestand kan niet worden opgeladen!<br>";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "Het bestand ".basename($_FILES["fileToUpload"]["name"])." werd geupload in de volgende map: ".$target_dir."<br>" ;
            $productName = $_POST["name"];
            $category = $_POST["category"];
            $price = $_POST["price"];
            $description = $_POST["description"];
            $sql = "INSERT INTO `product` (`product_id`, `image`, `name`, `category`, `price`, `beschrijving`) VALUES (NULL, '$fileName', '$productName', '$category', '$price', '$description');";
            
            if ($connect1->query($sql) === TRUE) {
                $endMsg = "Image added successfully";
            } else {
                $endMsg = "Database issue";
            }

        } else {
            $endMsg = "Issue while uploading";
        }
    }

echo '<script type="text/javascript"> alert("'.$endMsg.'")</script>';

}
?>
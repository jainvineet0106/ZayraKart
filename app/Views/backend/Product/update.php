<?php

include_once "../found/connection.php";

$id = $_GET["id"];

if(isset($_POST["categories"]))
{
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    $category = $_POST["categories"];
    
    if(
        trim($product_name) == "" ||
        trim($price) == "" ||
        trim($stock) == "" ||
        trim($category) == "" ||
        trim($description) == ""
        ){
        echo "<script>alert('missing field...');
        window.location.href = '../product.php';
        </script>";
        exit;
    }

    $data = $_POST['compressed_image'];
    if(!$data == ''){
        $data = explode(',', $data)[1];
        $data = base64_decode($data);
        $imgpath = "images/".$category. '.jpg';
        file_put_contents($imgpath, $data);
        $sql = "update products image = '$imgpath' where id = $id";
        $res = $conn->query($sql);
    }

    $sql = "select id from categories where category = '$category' ;";
    $cat = $conn->query($sql);
    $catgrow = $cat->fetch_assoc();
    $categories_id = $catgrow['id'];
    
    $sql = "update products set name = '$product_name', 
    description = '$description', 
    amount = '$price', 
    categories_id = '$categories_id', 
    stock = $stock where id = $id";
    $res = $conn->query($sql);



    // $data = $_POST['compressed_image'];
    // $data = explode(',', $data)[1];
    // $data = base64_decode($data);
    // file_put_contents('images/' . time() . '.jpg', $data);
    echo "<script>alert('Updated Product Added Successfully...');
    window.location.href = '../product.php';
    </script>";
}
else{
    echo "<script>alert('missing field...');
    window.location.href = '../addproduct.php';
    </script>";
}

?>
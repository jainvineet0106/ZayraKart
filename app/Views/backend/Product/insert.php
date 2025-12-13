<?php

include_once "../found/connection.php";

if(isset($_POST["categories"]))
{
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    $description = str_replace("'","_",$_POST["description"]);
    $category = $_POST["categories"];
    
    $data = $_POST['compressed_image'];
    $data = explode(',', $data)[1];
    $data = base64_decode($data);
    
    if($category == "Other")
    {
        $category = $_POST["new_category"];
        $imgpath = "../../assets/category_img/".$category. '.jpg';
        file_put_contents($imgpath, $data);
        $imgpath = "assets/category_img/".$category. '.jpg';
        $sql = "insert into categories(category, image) values('$category', '$imgpath')";
        $result = $conn->query($sql);
    }

    if(
        trim($product_name) == "" ||
        trim($price) == ""||
        trim($stock) == ""||
        trim($category) == ""||
        trim($description) == ""
        ){
        echo "<script>alert('missing field...');
        window.location.href = '../addproduct.php';
        </script>";
        exit;
    }

    $sql = "select id from categories where category = '$category' ;";
    $cat = $conn->query($sql);
    $catgrow = $cat->fetch_assoc();
    $categories_id = $catgrow['id'];

    $imgpath = "images/".$product_name. '.jpg';
    file_put_contents($imgpath, $data);

    $sql = "select product_id from products order by id desc limit 1;";
    $cat = $conn->query($sql);

    if($order->num_rows > 0){
        $catgrow = $cat->fetch_assoc();
        $product_id = $catgrow['product_id'];
        $input = ltrim($product_id, '#');
        preg_match('/([a-zA-Z]+)([0-9]+)/', $product_id, $matches);
        $number = $matches[2];
        $product_id = "#PRO".++$number;
    }
    else{
        $product_id = "#PRO01";
    }


    
    
    $sql = "insert into products(product_id, name, description, amount, image, categories_id, stock) 
    values('$product_id', '$product_name', '$description', '$price', '$imgpath', $categories_id, $stock);";

    $res = $conn->query($sql);

    // $data = $_POST['compressed_image'];
    // $data = explode(',', $data)[1];
    // $data = base64_decode($data);
    // file_put_contents('images/' . time() . '.jpg', $data);
    
    // echo "<script>alert('New Product Added Successfully...');
    // window.location.href = '../product.php';
    // </script>";

    echo "true";

}
else{
    echo "<script>alert('missing field...');
    window.location.href = '../addproduct.php';
    </script>";
}







?>
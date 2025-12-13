<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="icon" href="<?php echo base_url(); ?>public/frontend/assets/images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .back-btn {
            display: inline-block;
            background: #ddd;
            color: black;
            padding: 8px 15px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .back-btn i {
            margin-right: 5px;
        }

        .back-btn:hover {
            background: #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
        }

        table thead {
            background: #ff6a00;
            color: white;
        }

        table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .product-img {
            width: 60px;
            border-radius: 5px;
        }

        .qty-input {
            width: 50px;
            text-align: center;
            padding: 5px;
        }

        .remove-btn {
            color: red;
            font-size: 18px;
            cursor: pointer;
            transition: 0.2s;
        }

        .remove-btn:hover {
            transform: scale(1.2);
        }

        .cart-summary {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .checkout-btn {
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
            display: inline-block;
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #ee0979, #ff6a00);
        }

        @media (max-width: 768px) {
            table thead {
                display: none;
            }

            table, table tbody, table tr, table td {
                display: block;
                width: 100%;
            }

            table tr {
                margin-bottom: 20px;
                background: #f9f9f9;
                padding: 10px;
                border-radius: 8px;
            }

            table td {
                text-align: left;
                padding: 8px 10px;
            }

            table td img {
                max-width: 100px;
            }
        }
    </style>
</head>
<body>

    <div class="cart-container">

        <!-- Back Button -->
        <button class="back-btn" onclick="history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>

        <h1>Shopping Cart</h1>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                    <th>Buy</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($cart as $row){
                ?>
                <?php
                foreach($products as $item){
                    if($row['productid'] == $item['id']){
                ?>
                <tr class="cartproducts" id="row-<?php echo $row['id'];?>">
                    <td>
                        <img src="<?php echo base_url('public/frontend/images/Product/').$item['image'];?>" class="product-img" alt="Product">
                        <p><?php echo $item['name']; ?></p>
                    </td>
                    <td id="price-<?php echo $row['id'];?>">Rs.<?php echo $item['amount'];?></td>
                    <td><input type="number" id="qty-<?php echo $row['id'];?>" class="qty-input" value="<?php echo $row['quantity'];?>" min="1" onchange="total(<?php echo $row['id'];?>);"></td>
                    <td class="total"><span id="total-<?php echo $row['id'];?>">Rs.<?php echo $item['amount']*$row['quantity'];?></span></td>
                    <td><i onclick="remove(<?php echo $row['id'];?>);" class="fas fa-trash remove-btn"></i></td>
                    <td><a href="<?php echo site_url('buy/').encode_id($item['id'])."/".encode_id(session()->get('userid')).'/cart' ;?>" class="btn btn-sm btn-outline-primary">Buy this now</a></td>
                </tr>
                <?php } } } ?>
            </tbody>
        </table>

        <div class="cart-summary">
            Subtotal: <span id="cart-subtotal"></span><br>
             <a href="<?= site_url('placeorder/').encode_id(session()->get('userid'))?>" class="btn btn-primary px-4 py-2 fw-semibold">Place Order</a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        let totalprice = 0;
        let BASE_URL = "<?php echo base_url();?>";
        function updateSubtotal() {

            let totalamount = document.querySelectorAll('.total')
            let subtotal = 0;
            totalamount.forEach(item => {
                let tr = item.closest('tr');
                let display = window.getComputedStyle(tr).display;

                if (display !== 'none') {
                    subtotal += parseInt(item.innerText.replace('Rs.', ''));
                }

            });
            document.getElementById('cart-subtotal').innerText = 'Rs.' + subtotal;
            totalprice = subtotal;
        }

        window.addEventListener('DOMContentLoaded', updateSubtotal);

        function total(id){
            let qtyInputs = document.getElementById('qty-'+id);
            let total = document.getElementById('total-'+id);
            let price = document.getElementById('price-'+id);
            price = parseInt(price.innerText.replace('Rs.', ''));
            const newQty = parseInt(qtyInputs.value);
            totalprice = 'Rs.' + (newQty * price);
            total.innerText = totalprice;

            $.ajax({
                type: "POST",
                url: BASE_URL + "updatecart",
                data:{id: id, quantity: newQty}
            })
            updateSubtotal();
        }

        function remove(id){
            
            $.ajax({
                type: "GET",
                url: BASE_URL + "deleteData/"+id+"/cart/cart"
            })
            $("#row-"+id).fadeOut(800, function() {
                setTimeout(() => {
                    updateSubtotal();
                }, 500);
            });
        }
    </script>

</body>
</html>
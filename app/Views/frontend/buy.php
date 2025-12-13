<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout Page</title>
    <link rel="icon" href="<?php echo base_url();?>public/frontend/assets/images/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 0.5rem;
        }

        .card-img-top {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .qty-input {
            width: 60px;
        }

        .summary-box {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .order-summary li {
            font-size: 0.95rem;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row g-4">

            <!-- Left Column: Product Info -->
            <?php 
            if(isset($qty)){
                foreach($qty as $proqty){
                    $quantity = $proqty['quantity'];
                }
            }else{
                $quantity = 1;
            }
            foreach ($products as $pro) {
                $product = [
                    'proid' => $pro['id'],
                    'name' => $pro['name'],
                    'amount' => $pro['amount'],
                    'description' => $pro['description'],
                    'image' => $pro['image']
                ];
            }
            ?>
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 overflow-hidden">
                    <!-- Product Image -->
                    <div class="ratio ratio-4x3 bg-light">
                        <img src="<?= base_url('public/frontend/images/Product/') . $product['image']; ?>" 
                             class="w-100 h-100 object-fit-contain p-2" 
                             alt="<?= htmlspecialchars($product['name']); ?>">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Product Name -->
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($product['name']); ?></h5>

                        <!-- Price -->
                        <p class="text-primary fw-semibold mb-2">Rs.<span id="unitPrice"><?= $product['amount']; ?></span></p>

                        <!-- Description -->
                        <?php if (!empty($product['description'])): ?>
                            <p class="text-muted small mb-3"><?= htmlspecialchars($product['description']); ?></p>
                        <?php endif; ?>

                        <!-- Quantity Selector -->
                        <div class="mt-auto d-flex align-items-center gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-circle" onclick="updateQty(-1)">-</button>
                            <input type="text" id="buyQty" value="<?php echo $quantity;?>" class="form-control qty-input text-center rounded-pill">
                            <button class="btn btn-outline-primary btn-sm rounded-circle" onclick="updateQty(1)">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Checkout Form -->
            <div class="col-lg-7">
                <div class="summary-box">
                    <h5 class="mb-3">Shipping Address</h5>
                    <form method="post" id="checkoutForm">
                        <input type="hidden" id="buyQtyin" name="buyQtyin" value="1">

                        <!-- Saved Addresses Dropdown -->
                        <div class="mb-3">
                            <label for="savedAddress" class="form-label">Select Address</label>
                            <select class="form-select" id="savedAddress" name="saved_address">
                                <option value="">-- Choose saved address --</option>
                                <?php foreach ($addresses as $address): ?>
                                    <option value="<?= $address['id'] ?>">
                                        <?= $address['title'] ?>, <?= $address['address'] ?> (<?= $address['pincode'] ?>), <?= $address['mobile'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="toggleNewAddress">
                                + Add New Address
                            </button>
                        </div>

                        <div id="newAddressFields" style="display:none;">
                            <div class="mb-2">
                                <input type="text" class="form-control form-control-sm" name="title" placeholder="Full Name" id="newName">
                            </div>
                            <div class="mb-2 d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" name="mobile" placeholder="Mobile" id="newmobile">
                                <input type="text" class="form-control form-control-sm" name="address" placeholder="Address" id="newCity">
                                <input type="text" class="form-control form-control-sm" name="pincode" placeholder="Pincode" id="newPincode">
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <h5 class="mb-3 mt-3">Order Summary</h5>
                        <ul class="list-group mb-3 order-summary">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span><strong>Rs.<span id="subtotal"><?= $quantity*$product['amount']; ?></span></strong>
                                <input type="hidden" name="subtotal" id="subtotalin" value="<?= $quantity*$product['amount']; ?>">
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Packaging</span><strong>Rs.<span id="packaging">99</span></strong>
                                <input type="hidden" name="packaging" id="packagingin" value="99">
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tax</span><strong>Rs.<span id="tax">180</span></strong>
                                <input type="hidden" name="tax" id="taxin" value="180">
                            </li>
                            <li class="list-group-item d-flex justify-content-between fw-bold">
                                <span>Total</span><strong>Rs.<span id="total"><?= $quantity*$product['amount'] + 99 + 180; ?></span></strong>
                                <input type="hidden" name="total" id="totalin" value="<?= $quantity*$product['amount'] + 99 + 180; ?>">
                            </li>
                        </ul>

                        <!-- Place Order Button -->
                        <div class="d-flex justify-content-between mb-3">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.history.back()">Cancel</button>
                            <button type="button" class="btn btn-primary btn-sm" id="showPaymentBtn">Place Order</button>
                        </div>

                        <!-- Payment Method (Initially Hidden) -->
                        <div id="paymentMethodSection" style="display:none;">
                            <h6 class="mt-3 mb-2">Payment Method</h6>
                            <div class="payment-method mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="cod" value="cash" checked>
                                    <label class="form-check-label" for="cod">Cash on Delivery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="card" value="card">
                                    <label class="form-check-label" for="card">Credit/Debit Card</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment" id="upi" value="upi">
                                    <label class="form-check-label" for="upi">UPI</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success btn-sm">Confirm Order</button>
                            </div>
                        </div>

                        

                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>

        function Checkaddress(){
            let savedAddress = document.getElementById('savedAddress').value;
            let newName = document.getElementById('newName').value.trim();
            let newCity = document.getElementById('newCity').value.trim();
            let newPincode = document.getElementById('newPincode').value.trim();

            // Validation
            if (!savedAddress) {
                // No saved address selected
                if (!newName || !newCity || !newPincode) {
                    return false;
                }
            }
            return true
        }
        // Toggle New Address Fields
        document.getElementById('toggleNewAddress').addEventListener('click', function() {
            let newAddressDiv = document.getElementById('newAddressFields');
            newAddressDiv.style.display = newAddressDiv.style.display === 'none' ? 'block' : 'none';
        });

        // Show Payment Method on Place Order click with validation
        document.getElementById('showPaymentBtn').addEventListener('click', function() {
            if(!Checkaddress()){
                alert('Please Select or Add Shipping address!');
                return
            }

            // Show Payment Method
            document.getElementById('paymentMethodSection').style.display = 'block';
            this.style.display = 'none'; // hide Place Order button
            window.scrollTo({ top: document.getElementById('paymentMethodSection').offsetTop, behavior: 'smooth' });
        });

        // Update Quantity and Grand Total
        function updateQty(val) {
            let qtyInput = document.getElementById('buyQty');
            let current = parseInt(qtyInput.value) || 1;
            current += val;
            if (current < 1) current = 1;
            qtyInput.value = current;
            document.getElementById('buyQtyin').value = current;
            updateTotal();
        }

        function updateTotal() {
            let qty = parseInt(document.getElementById('buyQty').value) || 1;
            let unitPrice = parseInt(document.getElementById('unitPrice').textContent);
            let subtotal = unitPrice * qty;
            let packaging = parseInt(document.getElementById('packaging').textContent);
            let tax = parseInt(document.getElementById('tax').textContent);
            let total = subtotal + packaging + tax;

            document.getElementById('subtotal').textContent = subtotal;
            document.getElementById('total').textContent = total;
            document.getElementById('subtotalin').value = subtotal;
            document.getElementById('totalin').value = total;

        }

        // Optional: Form submit simulation
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
            if(!Checkaddress()){
                alert('Please Select or Add Shipping address!');
                return
            }
            window.location.href = '<?php echo site_url('buy/').encode_id($product['proid']).'/'.encode_id(session()->get('userid'));?>';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Refund Management Dashboard</title>
    <link rel="icon" href="<?php echo base_url(); ?>public/frontend/assets/images/favicon.png" />

    <style>
        :root {
            --bg: #0f1724;
            --card: #0b1220;
            --muted: #9aa4b2;
            --accent: #06b6d4;
            --glass: rgba(255, 255, 255, 0.03)
        }

        * {
            box-sizing: border-box;
            font-family: Inter, ui-sans-serif, system-ui, Segoe UI, Roboto, "Helvetica Neue", Arial
        }

        body {
            margin: 0;
            background: linear-gradient(180deg, #071025 0%, #081827 100%);
            color: #e6eef6;
            /* padding: 28px */
        }

        .container {
            max-width: 980px;
            margin: 0 auto
        }

        header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px
        }

        h1 {
            font-size: 20px;
            margin: 0
        }

        p.lead {
            color: var(--muted);
            margin: 0
        }

        .card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.03)
        }

        .items-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 420px;
            overflow: auto;
            padding-right: 6px
        }

        .item {
            padding: 12px;
            border-radius: 10px;
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.02)
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item:hover {
            transform: translateY(-2px);
            transition: all .15s
        }

        .item input[type=radio] {
            width: 18px;
            height: 18px
        }

        .items-list label {
            display: flex;
            justify-content: space-between;
        }

        .meta {
            display: flex;
            flex-direction: column
        }

        .meta .title {
            font-weight: 600
        }

        .meta .desc {
            color: var(--muted);
            font-size: 13px
        }


        label.price {
            margin-left: auto;
            font-weight: 700
        }

        form .field {
            margin-bottom: 12px
        }

        label.small {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 6px
        }

        input[type=text],
        input[type=number],
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: transparent;
            color: inherit
        }

        .muted {
            color: var(--muted);
            font-size: 13px
        }

        .row {
            display: flex;
            gap: 10px
        }

        button.primary {
            background: rgba(33, 150, 243, 0.15);
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
            color: #4dabff;
            box-shadow: 0 0 10px rgba(33, 150, 243, 0.3);
            cursor: pointer;
            border: none;
        }

        button.ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.04);
            padding: 8px 12px;
            border-radius: 8px;
            color: var(--muted);
            cursor: pointer
        }

        .summary {
            font-size: 14px
        }

        .note {
            font-size: 13px;
            color: var(--muted)
        }

        .json-out {
            white-space: pre-wrap;
            background: #061020;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.02);
            font-family: monospace;
            font-size: 13px
        }

        footer {
            margin-top: 12px;
            text-align: right
        }

        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.03);
            padding: 6px 8px;
            border-radius: 8px;
            font-weight: 600
        }

        img {
            width: 100%;
            height: 100%;
        }

        .nav-logo {
            width: 25%;
        }

        .custom-select-container {
            width: 250px;
            /* adjust as needed */
        }

        .custom-select-container select {
            width: 100%;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #1a1a1a;
            background-color: #0d1b2a;
            /* dark blue background */
            color: #ffffff;
            /* white text */
            font-size: 16px;
            appearance: none;
            /* remove default arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Hover and focus effects */
        .custom-select-container select:hover,
        .custom-select-container select:focus {
            background-color: #1b2a47;
            border-color: #2a4a7b;
            outline: none;
        }

        /* Optional: add a custom arrow */
        .custom-select-container {
            position: relative;
        }

        .custom-select-container::after {
            content: "▼";
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            pointer-events: none;
            color: #ffffff;
            font-size: 12px;
        }

        @media(max-width:880px) {
            .card {
                padding: 14px
            }

            .nav-logo {
                width: 50%;
            }
        }
    </style>
</head>

<?php
foreach ($orders as $order) {
    $orderid = $order['orderid'];
    $userid = $order['userid'];
    $buyproductid = $order['buyproductid'];
    $address = $order['address'];
    $total = $order['total'];
    $paymentmode = $order['paymentmode'];
    $orderat = $order['orderat'];
    $deliveredDate = $order['deliverdat'];
}
?>

<body>
    <div class="container">
        <header>
            <a href="<?php echo site_url('/'); ?>" class="nav-logo">
                <img src="<?php echo base_url('public/frontend/images/bg/') ?>logo2.png" alt="ZayraKart">
            </a>
            <div>
                <h1>Refund Management Dashboard</h1>
            </div>
        </header>

        <section class="card">
            <h3 style="margin-top:0">1) Items — select the item to refund</h3>

            <div class="items-list" id="itemslist">
            </div>

            <hr style="margin:16px 0;border-color:rgba(255,255,255,0.03)">

            <h3 style="margin:0 0 8px">2) Order & refund details</h3>
            <form action="<?= base_url('Profile/returnitem/' . encode_id($orderid)); ?>" onsubmit="return submitRefund(event)" method="post" id="refundForm"
                autocomplete="off">
                <div class="row">
                    <div style="flex:1" class="field">
                        <label class="small">Order Number</label>
                        <span id="ordernumber"></span>
                    </div>
                    <div style="width:120px" class="field">
                        <label class="small">Amount (Rs. )</label>
                        <span id="amountLabel"></span>
                    </div>
                </div>
                <div class="row">
                    <div style="flex:1; display:none;" class="field">
                        <label class="small">Customer id</label>
                        <span id="customerid"></span>
                    </div>
                    <div style="flex:1" class="field">
                        <label class="small">Customer Name</label>
                        <span id="customerName"></span>
                    </div>
                    <div style="flex:1" class="field">
                        <label class="small">Contact</label>
                        <span id="contactLabel"></span>
                    </div>
                    <div style="flex:1" class="field">
                        <label class="small">Address</label>
                        <span id="addressLabel"></span>
                    </div>
                    <div style="flex:1" class="field">
                        <label class="small">Order Date</label>
                        <span id="orderDate"></span>
                    </div>
                    <div style="flex:1" class="field">
                        <label class="small">Delivered Date</label>
                        <span id="deliveredDate"></span>
                    </div>
                </div>

                <div class="field">
                    <label class="small">Reason for refund</label>
                    <div class="custom-select-container" id="reasonSelect">
                        <select name="reason" required>
                            <option value="" selected disabled>Select an option</option>
                            <option value="Product damaged/defective">Product damaged/defective</option>
                            <option value="Wrong product delivered">Wrong product delivered</option>
                            <option value="Missing parts or accessories">Missing parts or accessories</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="small">UPI ID (for refund)</label>
                    <input type="text" id="upi" name="UPIid" placeholder="example@okaxis or name@bank" required />
                    <div class="muted" id="upiHelp">UPI id format: something@bank. We'll validate basic structure.
                    </div>
                </div>

                <div style="display:flex;gap:10px;align-items:center;margin-top:6px">
                    <button type="submit" name="submitBtn" id="submitBtn" class="primary">Submit refund request</button>
                    <button type="reset" id="clearBtn" class="ghost">Reset</button>
                </div>
            </form>

            <div style="margin-top:14px">
                <div class="summary"><strong>Selected Items:</strong> <span id="selectedLabel" class="muted">All item
                        selected</span></div>
            </div>
        </section>
    </div>

    <script>
        let itemslist = document.getElementById('itemslist');
        let ordernumber = document.getElementById('ordernumber');
        let customerName = document.getElementById('customerName');
        let contactLabel = document.getElementById('contactLabel');
        let addressLabel = document.getElementById('addressLabel');
        let customerid = document.getElementById('customerid');
        let orderDate = document.getElementById('orderDate');
        let deliveredDate = document.getElementById('deliveredDate');
        let amountLabel = document.getElementById('amountLabel');


        function fetchdetail(url, id) {
            return fetch("<?= base_url('Profile/'); ?>" + url + "/" + id)
                .then(response => response.json())
                .catch(error => {
                    console.error("Error fetching order:", error);
                    throw error;
                });
        }
        async function view() {
            try {
                const customer = await fetchdetail('getcustomer', <?= $address ?>);
                const items = [];
                const productIds = <?php echo json_encode($buyproductid); ?>.split("#@");
                for (const pid of productIds) {
                    const product = await fetchdetail('getproduct', pid);
                    const productquantity = await fetchdetail('getbuyproducts', pid + "/" + '<?= $orderid ?>');
                    if (product) {
                        items.push({
                            name: product.name,
                            qty: productquantity.quantity,
                            prid: productquantity.productid,
                            price: product.amount * productquantity.quantity
                        });
                    }
                }

                let sum = 0;
                for (let i = 0; i < items.length; i++) {
                    let itemsHTML = itemslist.innerHTML;
                    const div = document.createElement('label');
                    div.className = 'item';
                    div.innerHTML = `\n 
                    <div class='item-info'>
                        <input type="checkbox" name="selectedItem[]" value="${items[i].prid}" checked>\n 
                        <div class="meta">\n 
                            <span class="title" id="item-title-${items[i].prid}">${items[i].name}</span>\n
                            <span class="desc">• 
                                <span class="muted">
                                    Quantity: ${items[i].qty}
                                </span>
                            </span>
                        </div>
                    </div>\n 
                    <div class="price" id='item-price-${items[i].prid}'>Rs. ${parseInt(items[i].price).toFixed(2)}</div>\n `;
                    itemslist.appendChild(div);
                    sum = sum + items[i].price;
                }

                ordernumber.innerText = "<?= $orderid ?>";
                customerid.innerText = customer.id;
                customerName.innerText = customer.title;
                contactLabel.innerText = customer.mobile;
                addressLabel.innerText = customer.address + "(" + customer.pincode + ")";
                orderDate.innerText = '<?= $orderat ?>';
                deliveredDate.innerText = '<?= $deliveredDate ?>';
                return 'done';
            } catch (error) {
                alert("Failed to open order modal:" + error);
            }
        }
        function quickView(checkboxes, result) {
            const selected = Array.from(checkboxes)
                .filter(i => i.checked)
                .map(i => i.value);

            let title = [];
            let amount = [];

            for (let i = 0; i < selected.length; i++) {
                itemtitle = document.getElementById('item-title-' + selected[i]);
                itemprice = document.getElementById('item-price-' + selected[i]);
                title.push(itemtitle.innerText);
                amount.push(itemprice.innerText.replace('Rs. ', ''));
            }
            amountLabel.innerText = "Rs. " + amount.reduce((acc, curr) => acc + parseFloat(curr), 0).toFixed(2);
            result.innerText = selected.length
                ? title.join(', ')
                : "No item selected";

            if (result.innerText == "No item selected") {
                alert("Please select at least one item to proceed with the refund.");
                document.getElementById('submitBtn').disabled = true;
                document.getElementById('submitBtn').innerText = "Please select at least one item to proceed with the refund.";
            } else {
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('submitBtn').innerText = "Submit refund request";
            }
        }
        view()
            .then(res => {
                const checkboxes = document.querySelectorAll('input[name="selectedItem[]"]');
                let result = document.getElementById('selectedLabel');
                quickView(checkboxes, result);
                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener('change', () => quickView(checkboxes, result));
                });
            })
            .catch(err => console.log("Rejected:", err));



        function addHidden(form, name, value) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }
        function submitRefund() {
            event.preventDefault();
            const form = document.getElementById('refundForm');
            const selectedItems = [];
            document.querySelectorAll('input[name="selectedItem[]"]:checked').forEach((checkbox) => {
                selectedItems.push(checkbox.value);
            });

            if (selectedItems.length === 0) {
                alert("Please select at least one item to proceed with the refund.");
                return;
            }

            addHidden(form, 'orderid', "<?= $orderid ?>");
            addHidden(form, 'amount', amountLabel.innerText.replace('Rs. ', ''));
            addHidden(form, 'customerid', customerid.innerText);
            addHidden(form, 'name', customerName.innerText);
            addHidden(form, 'mobile', contactLabel.innerText);
            addHidden(form, 'address', addressLabel.innerText);
            addHidden(form, 'items', selectedItems.join(','));

            form.submit();
        }
    </script>

</body>

</html>
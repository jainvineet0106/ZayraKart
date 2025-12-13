<?php include 'include/header.php'; ?>

<style>
  .page-header {
    background: linear-gradient(90deg, #f3e6ff, #ede0ff);
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    color: #3c0063;
  }

  .table thead th {
    background: #ede0ff;
    color: #3c0063;
    text-align: center;
    vertical-align: middle;
  }

  .table tbody td {
    text-align: center;
    vertical-align: middle;
  }

  .status-Returned {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    background: linear-gradient(90deg, #6f42c1, #9b6ff4);
    color: #fff;
  }

  .status-Returned-Requested {
    background: linear-gradient(90deg, #ffc107, #ffd966);
    color: #212529;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
  }

  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .search-bar {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 15px;
  }

  .search-bar input {
    width: 250px;
    border-radius: 8px;
    border: 1px solid #d2bfff;
    padding: 6px 10px;
  }

  .search-bar input:focus {
    outline: none;
    border-color: #a871ff;
    box-shadow: 0 0 4px rgba(168, 113, 255, 0.5);
  }
</style>

<body>

  <?php include 'include/sidebar.php'; ?>
  <div class="content" id="content_slide">
    <?php include 'include/head.php'; ?>

    <div class="container-fluid mt-4">
      <!-- Page Header -->
      <div class="page-header d-flex align-items-center justify-content-between">
        <h4 class="mb-0"><i class="bi bi-arrow-repeat me-2"></i> Returned Orders</h4>
        <span class="badge bg-light text-dark">Total Returned: <?= count($returnedOrders); ?></span>
      </div>

      <!-- Search Bar -->
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by Order ID or Customer Name...">
      </div>

      <!-- Orders Table -->
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Mobile</th>
                  <th>Amount (Rs.)</th>
                  <th>Return Date</th>
                  <th>Reason</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="returnedTable"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 mt-4">
      <div class="text-center">
        <?php echo $pager->links('default', 'custom') ?>
      </div>
    </div>
  </div>
  <?php include 'include/footer.php'; ?>

  <div class="modal fade" id="returnedModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content card-curve">
        <div class="modal-header">
          <h5 class="modal-title">Order Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalContent"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Search Filter JS -->
  <script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
      let value = this.value.toLowerCase();
      document.querySelectorAll("#returnedTable tr").forEach(function (row) {
        row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
      });
    });
  </script>
  <?php
  $ordersJson = json_encode($returnedOrders, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  ?>

  <script>
    const returnedModal = new bootstrap.Modal(document.getElementById('returnedModal'));
    const returnedOrders = JSON.parse('<?php echo $ordersJson; ?>');

    let returnedTable = document.getElementById('returnedTable');

    function fetchdetail(url, id) {
      return fetch("<?= base_url(); ?>" + url + "/" + id)
        .then(response => response.json())
        .catch(error => {
          console.error("Error fetching order:", error);
          throw error;
        });
    }

    async function returnOrder(orderJson) {
      try {
        const customer = await fetchdetail('getcustomer', orderJson.address);
        const orderJsonStr = encodeURIComponent(JSON.stringify(orderJson));
        let returnHtml = `
          <tr>
          <td>${orderJson.orderid}</td>
          <td>${customer.title}</td>
          <td>${customer.mobile}</td>
          <td>${orderJson.total}</td>
          <td>${orderJson.requestdate}</td>
          <td>${orderJson.reason}</td>
          <td><span class="status-${orderJson.status.replace(" ", "-")}">${orderJson.status}</span></td>
          <td>
            <button type='button' onclick="view('${orderJsonStr}')" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-eye"></i> View
            </button>
          </td>
          </tr>
          `
        returnedTable.insertAdjacentHTML('afterbegin', returnHtml);
      } catch (error) {
        console.error("Error returning order:", error);
      }
    }
    if (!returnedOrders.length) {
      let returnHtml = `
          <tr>
            <td colspan="8" class="text-muted">No returned orders found.</td>
          </tr>
          `
      returnedTable.insertAdjacentHTML('beforeend', returnHtml);
    } else {
      returnedOrders.forEach(order => {
        returnOrder(order);
      });
    }
    async function view(orderData) {
      try {
        const orderJson = JSON.parse(decodeURIComponent(orderData));
        const order = await fetchdetail('getorders', orderJson.orderid);
        const customer = await fetchdetail('getcustomer', orderJson.address);
        const modalContent = document.getElementById('modalContent');

        const items = [];
        
        const productIds = orderJson.buyproductid.split("#@");
        for (const pid of productIds) {
          const product = await fetchdetail('getproduct', pid);
          const productquantity = await fetchdetail('getbuyproducts', pid + "/" + orderJson.orderid);
          if (product) {
            items.push({
              name: product.name,
              image: product.image,
              qty: productquantity.quantity,
              price: product.amount,
              status: productquantity.status
            });
          }
        }
        
        const itemsHtml = items.map(it => `<div class="d-flex align-items-center mb-2">
        <img src="<?php echo base_url('public/frontend/images/Product/') ?>${it.image}" style="width:48px;height:48px;object-fit:cover;border-radius:6px;margin-right:10px;">
        <div>
        <div style="font-weight:600">${it.name}</div>
        <div class="small-muted">Qty: ${it.qty} | Rs.${it.price}</div>
        </div>
        <div class="ms-auto"><strong>Rs.${(it.qty * it.price).toFixed(2)}</strong></div>
        <div class="ms-auto"><span class="badge status-${it.status}">${it.status}</span></div>
        </div>`).join('');
        
        modalContent.innerHTML = `
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Order Details</h5>
              <span class="badge bg-light text-primary fs-6">Order ID: <span id = 'currentOrder'>${orderJson.orderid}</span></span>
            </div>
          </div>
  
          <div class="card-body">
  
            <!-- Customer Details -->
            <h6 class="text-secondary fw-bold mb-2 border-bottom pb-1">Customer Details</h6>
            <div class="row mb-3">
              <div class="col-md-6">
                <strong>Name:</strong> ${customer.title}<br>
              </div>
              <div class="col-md-6">
                <strong>Phone:</strong> ${customer.mobile}
              </div>
            </div>
  
            <!-- Shipping Info -->
            <h6 class="text-secondary fw-bold mb-2 border-bottom pb-1">Shipping Information</h6>
            <div class="mb-3">
              <strong>Address:</strong><br>
              <small class="text-muted">
                ${customer.address}
              </small><br>
              <strong>Pincode:</strong> ${customer.pincode}
            </div>
  
            <!-- Order Summary -->
            <h6 class="text-secondary fw-bold mb-2 border-bottom pb-1">Order Summary</h6>
            <ul class="list-group list-group-flush mb-3 small border rounded">
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Order Date:</strong></span>
                <span>${order.orderat}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Expected Delivery:</strong></span>
                <span>${order.deliverdat}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Return Date:</strong></span>
                <span>${orderJson.requestdate}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Payment Mode:</strong></span>
                <span>${order.paymentmode}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Payment Status:</strong></span>
                <span>${order.paystatus}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Refund Status:</strong></span>
                <span>${orderJson.refundstatus}</span>
              </li>
            </ul>
  
            
            </div>
            </div>
            
            <hr>
            <h6 class="fw-bold mb-3">Ordered Items:</h6>
            ${itemsHtml}
            <hr>
            <!-- Price Breakdown -->
            <h6 class="text-secondary fw-bold mb-2 border-bottom pb-1">Price Breakdown</h6>
            <div class="text-end">
              <div class="fs-5 fw-bold mt-2 text-success">Total: Rs.${orderJson.total}</div>
            </div>
        `;

        returnedModal.show();
      } catch (error) {
        alert(error);
        // alert("Failed to open returned modal:", error);
      }

    }
  </script>

</body>
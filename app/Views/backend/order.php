<?php include_once "include/header.php"; ?>

<style>
  .card-curve {
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
    border: none;
  }

  .summary-card {
    border-radius: 12px;
    padding: 18px;
    text-align: center;
  }

  .summary-card h6 {
    margin: 0;
    font-weight: 600;
    font-size: 13px;
    color: #495057;
  }

  .summary-card h3 {
    margin: 4px 0 0 0;
    font-weight: 700;
  }

  .table-modern {
    border-collapse: separate;
    border-spacing: 0 12px;
    width: 100%;
  }

  .table-modern thead th {
    background: linear-gradient(90deg, #343a40, #495057);
    color: #fff;
    border: none;
    padding: 12px;
  }

  .table-modern tbody tr {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    transition: transform .12s;
  }

  .table-modern tbody tr:hover {
    transform: translateY(-3px);
  }

  .table-modern td,
  .table-modern th {
    border: none;
    vertical-align: middle;
    padding: 12px;
  }

  .badge {
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 13px;
  }

  .action-btn {
    border-radius: 8px;
    padding: 6px 9px;
  }

  .small-muted {
    font-size: 12px;
    color: #6c757d;
  }

  .items-list img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 6px;
  }

  .timeline {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 8px;
  }

  .timeline .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 12px;
    color: #6c757d;
  }

  .timeline .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-bottom: 6px;
  }

  /* status colors */
  .status-Pending {
    background: linear-gradient(90deg, #6c757d, #adb5bd);
    color: #fff;
  }

  .status-Processing,
  .status-Returned-Requested {
    background: linear-gradient(90deg, #ffc107, #ffd966);
    color: #212529;
  }

  .status-Shipped {
    background: linear-gradient(90deg, #17a2b8, #45c6e5);
    color: #fff;
  }

  .status-Delivered {
    background: linear-gradient(90deg, #28a745, #3cd77a);
    color: #fff;
  }

  .status-Cancelled {
    background: linear-gradient(90deg, #dc3545, #ff6b6b);
    color: #fff;
  }

  .status-Returned {
    background: linear-gradient(90deg, #6f42c1, #9b6ff4);
    color: #fff;
  }

  /* Filter card */
  .filter-card {
    border-radius: 14px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.08);
    padding: 12px;
    background: #fff;
    margin-bottom: 20px;
  }

  .filter-card .form-control,
  .filter-card .form-select {
    border-radius: 10px;
    height: 38px;
  }

  @media (max-width:900px) {
    .table-modern thead {
      display: none;
    }

    .table-modern tbody td {
      display: flex;
      justify-content: space-between;
      padding: 12px 14px;
    }

    .table-modern tbody tr {
      display: block;
      margin-bottom: 12px;
    }
  }
</style>

<body>
  <?php include_once "include/sidebar.php"; ?>

  <div class="content" id="content_slide">
    <?php include_once "include/head.php"; ?>

    <div class="container py-5">

      <!-- Summary cards -->
      <?php
      $totalOrders = count($orders);
      $delivered = 0;
      $pending = 0;
      $processing = 0;
      $cancelled = 0;
      $returned = 0;
      $revenue = 0;
      foreach ($orders as $o) {
        $s = ucfirst(strtolower($o['status']));
        if ($s === 'Delivered') {
          $delivered++;
          $revenue += floatval($o['total']);
        }
        if ($s === 'Pending') {
          $pending++;
          $revenue += floatval($o['total']);
        }
        if ($s === 'Processing') {
          $processing++;
          $revenue += floatval($o['total']);
        }
        if ($s === 'Shipped') {
          $revenue += floatval($o['total']);
        }
        if ($s === 'Cancelled')
          $cancelled++;
        if ($s === 'Returned')
          $returned++;
      }
      ?>
      <div class="row g-3 mb-4">
        <!-- Total Orders -->
        <div class="col-md-2">
          <div class="card summary-card card-curve">
            <h6>Total Orders</h6>
            <h3><?php echo $totalOrders; ?></h3>
            <p class="small-muted mt-1">All time</p>
          </div>
        </div>
        <!-- Delivered -->
        <div class="col-md-2">
          <div class="card summary-card card-curve" style="background:linear-gradient(90deg,#e6ffed,#e0fff3);">
            <h6>Delivered</h6>
            <h3 id="Delivered"><?php echo $delivered; ?></h3>
            <p class="small-muted mt-1">Successful deliveries</p>
          </div>
        </div>
        <!-- Pending / Processing -->
        <div class="col-md-2">
          <div class="card summary-card card-curve" style="background:linear-gradient(90deg,#fff8e6,#fff3e0);">
            <h6>Pending / Processing</h6>
            <h3 id="Processing"><?php echo $pending + $processing; ?></h3>
            <p class="small-muted mt-1">Not yet delivered</p>
          </div>
        </div>
        <!-- Revenue -->
        <div class="col-md-2">
          <div class="card summary-card card-curve" style="background:linear-gradient(90deg,#f0f7ff,#e8f1ff);">
            <h6>Revenue</h6>
            <h3>Rs.<?php echo number_format($revenue, 2); ?></h3>
            <p class="small-muted mt-1">Total order value</p>
          </div>
        </div>
        <!-- Cancelled Orders -->
        <div class="col-md-2">
          <div class="card summary-card card-curve" style="background:linear-gradient(90deg,#ffe6e6,#ffd6d6);">
            <h6>Cancelled</h6>
            <h3 id="Cancelled"><?php echo $cancelled; ?></h3>
            <p class="small-muted mt-1">Orders cancelled by users</p>
          </div>
        </div>
        <!-- Returned Orders -->
        <div class="col-md-2">
          <div class="card summary-card card-curve" style="background:linear-gradient(90deg,#f3e6ff,#ede0ff);">
            <h6>Returned</h6>
            <h3 id="Returned"><?php echo $returned; ?></h3>
            <p class="small-muted mt-1">Orders returned after delivery</p>
          </div>
        </div>
      </div>

      <!-- Filter Bar -->
      <div class="filter-card">
        <div class="row g-2 align-items-center">
          <div class="col-md-3 col-sm-6">
            <input id="searchInput" type="text" class="form-control" placeholder="Search Order ID">
          </div>
          <div class="col-md-2 col-sm-6">
            <select id="paymentFilter" class="form-select">
              <option value="">All Payments</option>
              <option value="Paid">Paid</option>
              <option value="Unpaid">Unpaid</option>
              <option value="Refunded">Refunded</option>
            </select>
          </div>
          <div class="col-md-2 col-sm-6">
            <select id="statusFilter" class="form-select">
              <option value="">All Status</option>
              <option value="Pending">Pending</option>
              <option value="Processing">Processing</option>
              <option value="Shipped">Shipped</option>
              <option value="Delivered">Delivered</option>
              <option value="Cancelled">Cancelled</option>
              <option value="Returned">Returned</option>
            </select>
          </div>
          <div class="col-md-2 col-sm-6">
            <input id="dateFrom" type="date" class="form-control">
          </div>
          <div class="col-md-2 col-sm-6">
            <input id="dateTo" type="date" class="form-control">
          </div>
          <div class="col-md-1 col-sm-12 text-end">
            <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">Reset</button>
          </div>
        </div>
      </div>

      <!-- Orders Table -->
      <div class="card card-curve">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-modern align-middle" id="ordersTable">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Products</th>
                  <th>Customer</th>
                  <th>Order Date</th>
                  <th>Expected</th>
                  <th>Payment</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orders as $o):
                  $orderJson = htmlspecialchars(json_encode($o), ENT_QUOTES, 'UTF-8');
                  $items = explode('#@', $o['buyproductid']);
                  $moreCount = max(0, count($items) - 1);
                  ?>
                  <tr data-order='<?php echo $orderJson; ?>'>
                    <td><?php echo $o['orderid']; ?></td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <?php
                        $first = true;
                        foreach ($buyproducts as $BYP) {
                          if ($BYP['orderid'] == $o['orderid'] && $first) {
                            foreach ($products as $pro) {
                              if ($BYP['productid'] == $pro['id']) {
                                ?>
                                <img
                                  src="<?php echo base_url('public/frontend/images/Product/') . htmlspecialchars($pro['image']); ?>"
                                  alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                <div>
                                  <div style="font-weight:600;">
                                    <?php echo $pro['name'] ?>           <?php echo $moreCount > 0 ? " +$moreCount more" : ""; ?>
                                  </div>
                                  <div class="small-muted"><?php echo $moreCount + 1; ?> item(s)</div>
                                </div>
                                <?php
                                $first = false;
                              }
                            }
                          }
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <?php
                      foreach ($useraddress as $user) {
                        if ($o['address'] == $user['id']) {
                          $name = $user['title'];
                          $mobile = $user['mobile'];
                        }
                      }
                      ?>
                      <div><?php echo htmlspecialchars($name); ?></div>
                      <div class="small-muted"><?php echo htmlspecialchars($mobile); ?></div>
                    </td>
                    <td><?php echo date('d M Y', strtotime($o['orderat'])); ?></td>
                    <td><?php echo date('d M Y', strtotime($o['deliverdat'])); ?></td>
                    <td><?php echo htmlspecialchars($o['paystatus']); ?></td>
                    <td><span class="badge status-<?php echo $o['status']; ?>"><?php echo $o['status']; ?></span></td>
                    <td>Rs.<?php echo number_format($o['total'], 2); ?></td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-outline-primary action-btn"
                        onclick="view('<?php echo $o['orderid']; ?>')">View Order</button>
                      <?php
                      if (
                        $o['status'] != 'Cancelled' &&
                        $o['status'] != 'Returned' &&
                        $o['status'] != 'Returned-Requested' &&
                        $o['status'] != 'Delivered'
                      ) {
                        ?>
                        <div class="btn-group">
                          <button class="btn btn-sm btn-outline-secondary action-btn dropdown-toggle"
                            data-bs-toggle="dropdown"></button>
                          <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"
                                onclick="changeStatusPrompt(this,'Processing')">Processing</a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeStatusPrompt(this,'Shipped')">Shipped</a>
                            </li>
                            <li><a class="dropdown-item text-success" href="#"
                                onclick="changeStatusPrompt(this,'Delivered')">Delivered</a></li>
                            <li>
                              <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#"
                                onclick="changeStatusPrompt(this,'Cancelled')">Cancel</a></li>
                          </ul>
                        </div>
                        <?php
                      }
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <div class="col-md-12">
      <div class="text-center">
        <?php echo $pager->links('default', 'custom') ?>
      </div>
    </div>

  </div>


  <?php include_once "include/footer.php"; ?>

  <div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content card-curve">
        <div class="modal-header">
          <h5 class="modal-title">Order Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalContent"></div>
        <div class="modal-footer">
          <button id="printInvoiceBtn" onclick="printInvoiceBtn()" class="btn btn-outline-secondary">Print
            Invoice</button>
          <button onclick="markDeliveredBtn()" id="markDeliveredBtn" class="btn btn-success">Mark as Delivered</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));

    function fetchdetail(url, id) {
      return fetch("<?= base_url(); ?>" + url + "/" + id)
        .then(response => response.json())
        .catch(error => {
          console.error("Error fetching order:", error);
          throw error;
        });
    }

    async function view(id) {
      try {
        const order = await fetchdetail('getorders', id);
        const customer = await fetchdetail('getcustomer', order.address);
        const modalContent = document.getElementById('modalContent');

        if (order.status == 'Delivered') {
          document.getElementById('markDeliveredBtn').style.display = 'none';
          document.getElementById('printInvoiceBtn').style.display = 'block';
        }
        else if (order.status == 'Returned-Requested' || order.status == 'Returned' || order.status == 'Cancelled') {
          document.getElementById('markDeliveredBtn').style.display = 'none';
          document.getElementById('printInvoiceBtn').style.display = 'none';
        } else {
          document.getElementById('markDeliveredBtn').style.display = 'block';
          document.getElementById('printInvoiceBtn').style.display = 'block';
        }

        const items = [];

        const productIds = order.buyproductid.split("#@");
        for (const pid of productIds) {
          const product = await fetchdetail('getproduct', pid);
          const productquantity = await fetchdetail('getbuyproducts', pid + "/" + order.orderid);
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
              <span class="badge bg-light text-primary fs-6">Order ID: <span id = 'currentOrder'>${order.orderid}</span></span>
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
                <span><strong>Payment Mode:</strong></span>
                <span>${order.paymentmode}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span><strong>Payment Status:</strong></span>
                <span>${order.paystatus}</span>
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
              <div><strong>Subtotal:</strong> Rs.${order.subtotal}</div>
              <div><strong>Packaging:</strong> Rs.${order.packaging}</div>
              <div><strong>Tax:</strong> Rs.${order.tax}</div>
              <div class="fs-5 fw-bold mt-2 text-success">Total: Rs.${order.total}</div>
            </div>
      `;

        orderModal.show();
      } catch (error) {
        alert("Failed to open order modal:", error);
      }

    }


    function printInvoiceBtn() {
      let currentOrder = document.getElementById('currentOrder').innerText;
      if (!currentOrder) return;
      window.open("invoice/" + currentOrder, "_blank");
    }

    function markDeliveredBtn() {
      let currentOrder = document.getElementById('currentOrder').innerText;
      if (!currentOrder) return;
      changeStatus(currentOrder, 'Delivered');
      orderModal.hide();
      alert('Order marked as Delivered');
    }

    // Change status
    function changeStatusPrompt(el, newStatus) {
      const tr = el.closest('tr');
      const order = JSON.parse(tr.dataset.order);
      changeStatus(order.orderid, newStatus);
    }

    function changeStatus(orderId, newStatus) {
      const tr = [...document.querySelectorAll('#ordersTable tbody tr')]
        .find(r => JSON.parse(r.dataset.order).orderid === orderId);
      if (tr) {
        const badge = tr.querySelector('td span.badge');
        badge.textContent = newStatus;
        badge.className = 'badge status-' + newStatus;
        // Update dataset
        const order = JSON.parse(tr.dataset.order);
        order.status = newStatus;
        tr.dataset.order = JSON.stringify(order);
      }
      // alert(new);
      let BASE_URL = "<?php echo base_url(); ?>";
      $.ajax({
        type: "post",
        url: BASE_URL + "admin/changestate",
        data: { orderid: orderId, newStatus: newStatus },
        success: function (response) {
          let statusbar = JSON.parse(response);
          document.getElementById('Delivered').innerText = statusbar['Delivered'];
          document.getElementById('Processing').innerText = statusbar['Processing'];
        }
      });
    }
  </script>

  <script>
    // Client-side filtering
    const searchInput = document.getElementById('searchInput');
    const paymentFilter = document.getElementById('paymentFilter');
    const statusFilter = document.getElementById('statusFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const tableBody = document.querySelector('#ordersTable tbody');

    function filterAndRender() {
      const search = searchInput.value.toUpperCase();
      const pay = paymentFilter.value;
      const status = statusFilter.value;
      const from = dateFrom.value;
      const to = dateTo.value;

      Array.from(tableBody.querySelectorAll('tr')).forEach(tr => {
        const order = JSON.parse(tr.dataset.order);

        let match = true;

        // Search filter
        if (search) {
          const combined = [
            order.orderid,
          ].join(' ').toUpperCase();
          if (!combined.includes(search)) match = false;
        }

        // Payment filter
        if (pay && order.paystatus !== pay) match = false;

        // Status filter
        if (status && order.status !== status) match = false;

        // Date filter
        if (from && new Date(order.orderat) < new Date(from)) match = false;
        if (to && new Date(order.orderat) > new Date(to)) match = false;

        tr.style.display = match ? '' : 'none';
      });
    }

    function clearFilters() {
      searchInput.value = '';
      paymentFilter.value = '';
      statusFilter.value = '';
      dateFrom.value = '';
      dateTo.value = '';
      filterAndRender();
    }

    searchInput.addEventListener('input', filterAndRender);
    paymentFilter.addEventListener('change', filterAndRender);
    statusFilter.addEventListener('change', filterAndRender);
    dateFrom.addEventListener('change', filterAndRender);
    dateTo.addEventListener('change', filterAndRender);
  </script>

</body>
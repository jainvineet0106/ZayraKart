<?php include 'include/header.php'; ?>

<style>
  .badge {
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 13px;
  }

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
</style>

<body>

  <div id="imageModal"
    style="display:none; position:fixed; z-index:999; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8); text-align:center;">
    <span style="position:absolute; top:20px; right:35px; color:white; font-size:40px; cursor:pointer;"
      onclick="closeModal()">&times;</span>
    <img id="modalImg" style="margin:auto; max-width:90%; max-height:90%; margin-top:50px; border-radius:10px;">
  </div>

  <div class="container py-5">
    <div class="profile-card">

      <!-- Profile Header -->
      <a href="<?= site_url('/') ?>" class="btn logout-btn" style="float: left;">
        <i class="fas fa-arrow-left"></i> Back
      </a>

      <?php foreach ($user as $use) {
        $id = $use['id'];
        $image = $use['image'];
        $name = $use['name'];
        $email = $use['email'];
        $mobile = $use['mobile'];
      } ?>
      <div class="profile-header">
        <div class="profile-pic-wrapper"
          onclick="openModal('<?php echo base_url('public/frontend/images/useraccounts/') . $image; ?>')">
          <div
            class="rounded-circle border border-2 border-secondary d-flex justify-content-center align-items-center shadow-sm"
            style="width: 100px; height: 100px; color: #6c757d; font-size: 2.5rem; margin: auto; background-color: #f8f9fa;">
            <img src="<?php echo base_url('public/frontend/images/useraccounts/') . $image; ?>" alt="Profile Image">
          </div>
          <div class="edit-icon" onclick="document.getElementById('fileInput').click()">
            <i class="bi bi-pencil-fill"></i>
          </div>
          <input type="file" id="fileInput" accept="image/*" style="display: none;" onchange="previewImage(event)">
        </div>


        <h3><?php echo $name; ?></h3>
        <p><?php echo $email; ?></p>
      </div>

      <!-- Nav Tabs -->
      <ul class="nav nav-tabs justify-content-center border-0" id="profileTab" role="tablist">
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info" type="button">Personal
            Info</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders" type="button">Orders</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#addresses" type="button">Delevired
            Addresses</button>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content">

        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('openTab')): ?>
          <script>
            document.addEventListener("DOMContentLoaded", function () {
              var tabTrigger = document.querySelector('[data-bs-target="#<?= session()->getFlashdata('openTab'); ?>"]');
              if (tabTrigger) {
                var tab = new bootstrap.Tab(tabTrigger);
                tab.show();
              }
            });
          </script>
        <?php endif; ?>
        <!-- Personal Info -->
        <div class="tab-pane fade show active" id="info">


          <h5>Personal Details</h5>
          <p><strong>Name:</strong> <?php echo $name; ?></p>
          <p><strong>Email:</strong> <?php echo $email; ?></p>
          <p><strong>Mobile:</strong> +91-<?php echo $mobile; ?></p>
          <a href="<?php echo site_url('editprofile'); ?>">
            <button class="btn btn-sm btn-outline-primary">Edit Profile</button>
          </a>
        </div>

        <!-- Orders -->
        <div class="tab-pane fade" id="orders">
          <h5 class="mb-3">Order History</h5>
          <div class="card card-curve shadow-sm">
            <div class="card-body p-2">
              <div class="table-responsive">
                <table class="table table-sm table-hover table-modern align-middle" id="ordersTable">
                  <thead class="table-light">
                    <tr>
                      <th style="min-width:200px;">Products</th>
                      <th style="min-width:140px;">Dates</th>
                      <th style="min-width:80px;">Payment</th>
                      <th style="min-width:90px;">Status</th>
                      <th style="min-width:90px;">Total</th>
                      <th style="min-width:120px;" class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($orders as $o):
                      $orderJson = htmlspecialchars(json_encode($o), ENT_QUOTES, 'UTF-8');
                      $items = explode('#@', $o['buyproductid']);
                      $moreCount = max(0, count($items) - 1);
                      ?>
                      <tr data-order='<?php echo $orderJson; ?>'>
                        <!-- Products -->
                        <td class="py-1">
                          <div class="d-flex align-items-center gap-2 flex-wrap">
                            <?php
                            $first = true;
                            foreach ($buyproducts as $BYP) {
                              if ($BYP['orderid'] == $o['orderid'] && $first) {
                                foreach ($products as $pro) {
                                  if ($BYP['productid'] == $pro['id']) {
                                    ?>
                                    <div class="d-flex align-items-center gap-2">
                                      <img
                                        src="<?php echo base_url('public/frontend/images/Product/') . htmlspecialchars($pro['image']); ?>"
                                        alt="<?php echo htmlspecialchars($pro['name']); ?>" class="rounded"
                                        style="width:45px;height:45px;object-fit:cover;">
                                      <div class="d-flex flex-column">
                                        <span class="fw-bold" style="font-size:0.85rem;">
                                          <?php echo htmlspecialchars($pro['name']); ?>          <?php echo $moreCount > 0 ? " +$moreCount more" : ""; ?>
                                        </span>
                                        <span class="text-muted small"><?php echo $moreCount + 1; ?> item(s)</span>
                                      </div>
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

                        <!-- Dates -->
                        <td class="py-1">
                          <div class="d-flex flex-column small">
                            <span><strong>Order:</strong> <?php echo date('d M Y', strtotime($o['orderat'])); ?></span>
                            <span><strong>Expected:</strong>
                              <?php echo date('d M Y', strtotime($o['deliverdat'])); ?></span>
                          </div>
                        </td>

                        <!-- Payment -->
                        <td class="py-1 text-muted"><?php echo htmlspecialchars($o['paystatus']); ?></td>

                        <!-- Status -->
                        <td class="py-1">
                          <span
                            class="badge status-<?php echo $o['status']; ?> text-uppercase"><?php echo $o['status']; ?></span>
                        </td>

                        <!-- Total -->
                        <td class="py-1 fw-bold">Rs.<?php echo number_format($o['total'], 2); ?></td>

                        <!-- Actions -->
                        <td class="py-1 text-center">
                          <div class="d-inline-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center"
                              onclick="view(<?php echo $o['id']; ?>)">
                              <i class="bi bi-eye me-1"></i> View
                            </button>
                            <?php
                            if ($o['status'] != 'Cancelled' && $o['status'] != 'Returned' && $o['status'] != 'Returned-Requested') {
                              if ($o['status'] != 'Delivered') {
                                ?>
                                <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                  onclick="if (confirm('Are you sure you want to cancel this order?')) changeStatusPrompt(this, 'Cancelled')">
                                  <i class="bi bi-x-lg me-1"></i> Cancel
                                </button>
                                <?php
                              } else {
                                ?>
                                <a href="<?= site_url("/Profile/returnitem/") . encode_id($o['orderid']) ?>"
                                  class="btn btn-sm btn-outline-warning d-flex align-items-center">
                                  <i class="bi bi-arrow-return-left text-warning me-1"></i> Return
                                </a>
                                <?php
                              }
                            }
                            ?>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>


        <!-- Addresses -->
        <div class="tab-pane fade" id="addresses">
          <h5>Saved Addresses</h5>
          <?php foreach ($addresses as $address) { ?>
            <div class="d-flex justify-content-between align-items-start border p-2 rounded mb-2">
              <!-- Left: Title + Address + Pincode -->
              <div>
                <strong><?php echo $address['title']; ?>:</strong>
                <div><?php echo $address['address']; ?></div>
                <div class="text-muted"><?php echo $address['pincode']; ?></div>
                <div class="text-muted">Mobile: <?php echo htmlspecialchars($address['mobile']); ?></div>
              </div>

              <!-- Right: Edit / Delete Buttons -->
              <div>
                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editaddress"
                  data-id="<?php echo $address['id']; ?>" class="btn btn-sm btn-outline-primary me-2 mb-1">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="javascript:;" onclick="confirmdelete(<?php echo $address['id']; ?>, 'useraddress', 'Profile')"
                  class="btn btn-sm btn-outline-danger mb-1">
                  <i class="bi bi-trash"></i> Delete
                </a>
              </div>
            </div>


          <?php } ?>
          <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
            data-bs-target="#addaddress">Add New Address</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="editaddress" tabindex="-1" aria-labelledby="editaddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="registerModalLabel">Edit Address</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="editaddress" action="<?= base_url('editaddress') ?>" method="POST">
          <input type="hidden" name="addressid" id="modal-id">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" for="addressTitle">
                <i class="bi bi-tag-fill me-2"></i> Full Name
              </label>
              <input type="text" class="form-control" id="addressTitle" name="title" required
                placeholder="Enter Receiver Name">
            </div>
            <div class="mb-3">
              <label class="form-label" for="mobile">
                <i class="bi bi-tag-fill me-2"></i> Contact Number
              </label>
              <input type="text" class="form-control" id="mobile" name="mobile" required
                placeholder="Enter Receiver Contact Number">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">
                <i class="bi bi-geo-alt-fill me-2"></i> Address
              </label>
              <input type="text" class="form-control" id="address" name="address" required
                placeholder="e.g. 221B Baker Street, London">
              <div class="form-text">Enter your complete address including street, city, and zip code.</div>
            </div>
            <div class="mb-3">
              <label for="pincode" class="form-label">
                <i class="bi bi-mailbox me-2"></i> Pincode
              </label>
              <input type="text" class="form-control" id="pincode" name="pincode" required placeholder="e.g. 123456">
              <div class="form-text">Enter your area/zip code.</div>
            </div>
            <button type="submit" class="btn btn-success w-100">Update Address</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addaddress" tabindex="-1" aria-labelledby="addaddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="registerModalLabel">Add New Address</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="<?= base_url('Profile') ?>" id="newaddress" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label" for="addressTitle">
                <i class="bi bi-tag-fill me-2"></i> Full Name
              </label>
              <input type="text" class="form-control" id="addressTitle" name="title" required
                placeholder="Enter Receiver Name">
            </div>
            <div class="mb-3">
              <label class="form-label" for="mobile">
                <i class="bi bi-tag-fill me-2"></i> Contact Number
              </label>
              <input type="text" class="form-control" id="mobile" name="mobile" required
                placeholder="Enter Receiver Contact Number">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">
                <i class="bi bi-geo-alt-fill me-2"></i> Address
              </label>
              <input type="text" class="form-control" id="address" name="address" required
                placeholder="e.g. 221B Baker Street, London">
              <div class="form-text">Enter your complete address including street, city, and zip code.</div>
            </div>
            <div class="mb-3">
              <label for="pincode" class="form-label">
                <i class="bi bi-mailbox me-2"></i> Pincode
              </label>
              <input type="text" class="form-control" id="pincode" name="pincode" required placeholder="e.g. 123456">
              <div class="form-text">Enter your area/zip code.</div>
            </div>
            <button type="submit" class="btn btn-success w-100">Add Address</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="profileimage" tabindex="-1" aria-labelledby="profileimageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="registerModalLabel">Update Profile Image</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <img id="image" src="">
        <div class="text-center">
          <button id="cropButton" class="btn btn-success btn-lg mt-2">💾 Crop & Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content card-curve">
        <div class="modal-header">
          <h5 class="modal-title">Order Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalContent"></div>
      </div>
    </div>
  </div>

  <script>
    function previewImage(event) {
      let cropper;
      const file = event.target.files[0];
      const image = document.getElementById('image');
      image.src = URL.createObjectURL(file);
      image.onload = () => {
        if (cropper) cropper.destroy();
        cropper = new Cropper(image, {
          viewMode: 1,
          autoCropArea: 1,
          aspectRatio: 1,
          dragMode: 'move',
          cropBoxResizable: false,
          cropBoxMovable: false,
          ready() {
            cropper.setCropBoxData({ width: 300, height: 300 });
          }
        });
      };
      const modal = new bootstrap.Modal(document.getElementById('profileimage'));
      modal.show();

      $('#cropButton').on('click', function () {
        if (cropper) {
          cropper.getCroppedCanvas({ width: 250, height: 250 }).toBlob(function (blob) {
            let formData = new FormData();
            formData.append('croppedImage', blob, 'profile.jpg');
            let BASE_URL = '<?php echo base_url(); ?>';
            $.ajax({
              url: BASE_URL + 'uploadimage',
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                alert(response);
                modal.hide();
                setTimeout(function () {
                  window.location.reload();
                }, 500)
              }
            });
          }, 'image/jpeg', 0.8);
        }
      });


    }
  </script>
  <script>
    function openModal(src) {
      document.getElementById('modalImg').src = src;
      document.getElementById('imageModal').style.display = "block";
    }

    function closeModal() {
      document.getElementById('imageModal').style.display = "none";
    }
  </script>

  <script>
    var editModal = document.getElementById('editaddress');
    editModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');

      // Hidden input me set karo
      document.getElementById('modal-id').value = id;

      // Ajax call (example jQuery)
      fetch("<?= base_url(); ?>getAddress/" + id)
        .then(response => response.json())
        .then(data => {
          document.getElementById('addressTitle').value = data.title;
          document.getElementById('address').value = data.address;
          document.getElementById('pincode').value = data.pincode;
          document.getElementById('mobile').value = data.mobile;
        });
    });
  </script>

  <script>

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
      let BASE_URL = "<?php echo base_url(); ?>";
      $.ajax({
        type: "post",
        url: BASE_URL + "changestate",
        data: { orderid: orderId, newStatus: newStatus },
        success: function (response) {
        }
      })
    }

  </script>

  <script>
    const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    let currentOrder = null;

    function fetchdetail(url, id) {
      return fetch("<?= base_url('Profile/'); ?>" + url + "/" + id)
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
              <h5 class="mb-0">${order.orderid}</h5>
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
        alert("Failed to open order modal:" + error);
      }

    }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
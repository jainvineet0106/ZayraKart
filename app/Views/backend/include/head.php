<nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow-sm mb-4">
    <div class="container-fluid">
        <button class="btn btn-outline-secondary" id="toggle-btn">
            <i class="bi bi-list"></i>
        </button>
    <span class="navbar-brand d-flex align-items-center gap-3">
      <i class="bi bi-person-circle fs-4"></i>
      <span>Welcome To <?php echo session()->get('name');?></span>
    </span>
    </div>
</nav>

<script>
  const toggleBtn = document.getElementById('toggle-btn');
  const sidebar = document.getElementById('sidebar');
  const content_slide = document.getElementById('content_slide');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('sidebar-hidden');
    content_slide.classList.toggle('content_slide');
  });
</script>
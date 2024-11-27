<footer class="bg-light text-center text-lg-start fixed-bottom">
  <div class="text-center p-3">
    © <span id="currentYear"></span> MyApp. All rights reserved.
  </div>
</footer>
<!-- Optional: Add this script to dynamically set the year -->
<script>
  document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>

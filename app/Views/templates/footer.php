</div>
</div>
</div>

<footer class="bg-light text-center text-lg-start mt-auto">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © <?= date('Y'); ?> Laundry Application</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  setTimeout(function () {
    let alert = document.querySelector('.alert-dismissible');
    if (alert) {
      new bootstrap.Alert(alert).close();
    }
  }, 5000);
</script>
</body>

</html>
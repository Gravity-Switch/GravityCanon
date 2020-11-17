<?php
add_action("wp_footer", function () {
  ?>
  <script>
  jQuery(".helpful-button").addClass("btn");
  jQuery(".helpful-contra").addClass("btn--secondary");
  </script>
  <?php
});

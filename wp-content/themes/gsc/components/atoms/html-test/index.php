<?php /*
<!-- Link styled as button -->
<a href="#" class="html-test">Contact Us</a>

<!-- Button element with base .html-test styling -->
<button type="button" class="html-test">Contact Us</button>
 */

 $defaults = [
   "content" => [
     "main" => "Test",
   ],
   "style" => [
     "class" => '',
     "id" => '',
   ]
 ];

gsc_define("html-test", $defaults, function ($data) {


  //wrap classes
  $class_attr = "class='{$class_attr}'";

  // add endquote to class def

  $text = $data["content"]["main"];
  ob_start();
  ?>
  <div class="html-test <?php $data["style"]["class"] ?>" id="<?php $data["style"]["id"] ?>">
    <?php echo $text ?>
  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();

  return $output;

});
gsc_meta("html-test", [ATOM]);
gsc_test("html-test", "primary", function() {
  echo gsc("html-test", []);
});

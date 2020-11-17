<?php
/**
 * Template Name: Component Test
 * Description: A full-width template with no sidebar
 *
 * @package WordPress
 * @subpackage Toolbox
 */

function get_component_meta_tags($component){
  $output = "";
  if (isset($component["meta"]) && !empty($component["meta"])) {
    $numMetas = count($component["meta"]);
    $i = 0;
    $output .= "<span class='component-meta'>(";
    foreach ($component["meta"] as $value) {
      $output .= "$value";
      if($i !== $numMetas-1) {
        $output .= ", ";
      }
      $i++;
    }
    $output .= ")</span>";
  }
  return $output;
}
function print_component_test($component_name, $component) {
  echo "<div id='$component_name-test' class='component-test-container'>";


  $meta = get_component_meta_tags($component);
  echo "<h2 class='component-test-heading'>{$component_name} {$meta}</h2>";
  if (isset($component["tester"]) && !empty($component["tester"]) && is_callable($component["tester"][0]["test"])) {
    foreach ($component["tester"] as $test_container) {
      echo "<div class='single-test'>";
      if (!empty($test_container["description"])) {
        echo "<h3>{$test_container["description"]}</h3>";
      }
      call_user_func($test_container["test"]);
      echo "</div>";
    }
  }
  else {
    echo "<p>No test defined.</p>";
  }
  echo "</div>";
}
get_header();

echo "<h1 class='component-test-heading'>GS Component Test</h1>";

global $_gscs;

if (empty($_gscs)) {
  echo "<h2 class='component-test-heading error'>No components found! Where did they go?</h2>";
}
else {

  if (!empty($_GET["only"])) {
    if (isset($_gscs[$_GET["only"]])) {
      print_component_test($_GET["only"], $_gscs[$_GET["only"]]);
    }
    else {
      echo "<h2 class='component-test-heading error'>Component {$_GET["only"]} not found...</h2>";
    }
  }
  else {
    echo '<ul class="quick-list">';
    foreach($_gscs as $component_name=>$component)  {
      $meta = get_component_meta_tags($component);
      echo "<li><a href='?only=$component_name'>$component_name</a> $meta</li>";
    }
    echo '</ul>';

    foreach ($_gscs as $component_name=>$component) {
      print_component_test($component_name, $component);
    }
  }

}
?>

<style>
  .component-test-container {
    padding: 2rem;
    min-height: 50vh;
  }
  .component-test-heading {
    text-align: center;
    border-bottom: 2px solid black;
  }
  .component-test-heading.error {
    color: #dd0000;
  }
  .single-test {
    padding: 1rem 0;
  }
  .component-meta {
    font-size: .75em;
  }
  @media (min-width: 48rem) {
    .quick-list {
      column-count: 2;
    }
    .quick-list li:before {
      content: none;
    }
  }
  @media (min-width: 72rem) {
    .quick-list {
      column-count: 3;
    }
  }
  @media print {
    .component-test-container {
      padding: 0;
      min-height: 0;
    }
  }
</style>
<?php

 get_footer();

<?php
global $_gscs;
$_gscs = [];
function gsc($component_name, $data) {
  global $_gscs;
  $component = $_gscs[$component_name];
  //var_dump($component);
  $data = gsc_flatten(array_replace_recursive($component["defaults"], $data));
  //$data = array_replace($component["defaults"], $data);
  return call_user_func($component["renderer"], $data);
}

function gsc_define($component_name, $defaults, $renderer) {
  global $_gscs;
  $_gscs[$component_name] = array(
    "defaults" => $defaults,
    "renderer" => $renderer
  );
}

function gsc_test($component_name, $description = false, $tester) {
  global $_gscs;
  if (!isset($_gscs[$component_name]["tester"])) {
    $_gscs[$component_name]["tester"] = [];
  }
  $_gscs[$component_name]["tester"][] = ["test" => $tester, "description" => $description];
}

// GSC META CONSTANTS
define("ATOM", "atom");
define("MOLECULE", "molecule");
define("ORGANISM", "organism");

function gsc_meta($component_name, $metas) {
  global $_gscs;
  $_gscs[$component_name]["meta"] = $metas;
}


// helper functions
function gsc_flatten($unknown) {
  if (is_callable($unknown)) {
    return call_user_func($unknown);
  }
  elseif (is_array($unknown)) {
    foreach ($unknown as $index=>$unk) {
      $unknown[$index] = gsc_flatten($unk);
    }
    return $unknown;
  }
  else {
    return $unknown;
  }
}
function gsc_mock(/*$property,*/ $mocker = null) {
  //global $are_mocking;
  $mock_data = "";
  //if (isset($_GET["mocker"]) || $are_mocking) {
    if (is_callable($mocker)) {
      $mock_data = call_user_func($mocker);
    }
    elseif (is_string($mocker)) {
      $mock_data = $mocker;
    }
    else {
      $mock_data = lorem_mocker();
    }
    return $mock_data;
    //$property = $mock_data;
  //}

  //return $property;
}
function lorem_mocker($options = '1/short/plaintext') {
  return file_get_contents('http://loripsum.net/api/'.$options);
}

<?php


 function year_shortcode() {
   $year = date('Y');
   return $year;
 }
 add_shortcode('year', 'year_shortcode');

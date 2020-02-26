<?php

$styles_url = get_stylesheet_directory_uri() . "/style.css";
echo '<div id="commento"></div>
<script defer
  src="https://cdn.commento.io/js/commento.js"
  data-css-override="'.$styles_url.'">
</script>';
?>
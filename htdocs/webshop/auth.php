<?php
  if (isset($_COOKIE['signed_in'])) {
    foreach ($_COOKIE['cookie'] as $name => $value) {
      $name = htmlspecialchars($name);
      $value = htmlspecialchars($value);
      echo "$name : $value <br />\n";
  }
  }
?>
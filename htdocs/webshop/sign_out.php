<?php
  if(isset($_POST['submit'])) {	
    if (isset($_COOKIE['signed_in'])) {
      unset($_COOKIE['signed_in']); 
      setcookie('signed_in', "", -1, '/'); 
    }
  }
?>
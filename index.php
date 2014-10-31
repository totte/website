<?php
function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

redirect('http://www.chakraos.org/home/', 303)
?>

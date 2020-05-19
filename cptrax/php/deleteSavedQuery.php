<?php

    header("Location: ../../cptrax.php",TRUE,303);

    $filename = $_GET['savedreportname'];
    $filename = "./savedqueries/".$filename.".php";

    !unlink($filename);


?>
<?php

    session_start();
    $_SESSION['rol']==0;
    session_destroy();
    
    header("location: ../login/login.php");

?>
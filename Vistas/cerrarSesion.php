<?php
    //reanudamos o obtenemos la sesión
    session_start();
    //la reiniciamos
    $_SESSION = array();
    //destruimos la sesión
    session_destroy();
    header("location: login");
?>
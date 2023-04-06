<?php

    if(!isset($_SESSION)) {
        session_start();
    }

    session_destroy();
    header("HTTP/1.1 302 Redirect");
    header("Location: index.php");
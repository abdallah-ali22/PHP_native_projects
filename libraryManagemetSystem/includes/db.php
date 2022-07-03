<?php
    $connect = mysqli_connect("localhost","root","","library");
    if(!$connect)
        die("Failed to connect " .mysqli_error($connect));
    
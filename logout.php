<?php
session_start();
$_SESSION['auth'] = null;
$_SESSION['username'] = null;
$_SESSION['status'] = null;
header("Location:index.php");
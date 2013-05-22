<?php
@session_start();

if(!isset($_SESSION['user']) && (!isset($allow_guests) || $allow_guests != true)){
    header("Location: ".PATH); exit;
}
?>
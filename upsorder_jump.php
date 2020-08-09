<?php

require_once 'header.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_GET['xl']) {    
    header("location:https://www.ups.com/track?loc=en_US&tracknum=" . $_GET['xl']);
    get_ups_status($_GET['xl']);
}
?>
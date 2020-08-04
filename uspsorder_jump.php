<?php
require_once 'header.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_GET['xl']) {
    get_status($_GET['xl']);
    header("location:https://tools.usps.com/go/TrackConfirmAction?tLabels=" . $_GET['xl']);
}
?>
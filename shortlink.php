<?php
require('showRedirect.php');
$id = $_GET['linkid'];
//First check user have uuid or timestamp
showRedirect($id);


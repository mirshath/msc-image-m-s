<?php
require_once '../../config/db.php';
require_once '../../src/Billing.php';

$billing = new Billing($pdo);
$total = $billing->getTotalCost($_SESSION['user']['id']);

echo "Total Cost: $total";
s
?>

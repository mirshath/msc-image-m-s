<?php
require_once '../../config/db.php';
require_once '../../src/Report.php';

$report = new Report($pdo);
$reports = $report->getReports($_SESSION['user']['id']);

foreach ($reports as $report) {
    echo "<p>Report: {$report['report_type']} - Created At: {$report['created_at']}</p>";
}
?>

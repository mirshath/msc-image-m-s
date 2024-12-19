<?php
class Report
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Request a report for a patient
    public function requestReport($patientId, $reportType)
    {
        $stmt = $this->pdo->prepare("INSERT INTO reports (patient_id, report_type, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$patientId, $reportType]);
    }

    // Get reports for a patient
    public function getReportsForPatient($patientId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM reports WHERE patient_id = ?");
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

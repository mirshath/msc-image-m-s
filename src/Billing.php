<?php
class Billing
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new bill
    public function createBill($patientId, $testType, $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO bills (patient_id, test_type, amount, paid_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$patientId, $testType, $amount]);
    }

    // Get bills for a patient
    public function getBillsForPatient($patientId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bills WHERE patient_id = ?");
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

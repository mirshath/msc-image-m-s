<?php


class TestBillManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    

    // Get tests for a specific patient
    public function getPatientTests($patient_id)
    {
        $stmt = $this->pdo->prepare("SELECT t.id, t.test_name FROM tests t JOIN appointments a ON t.appointment_id = a.id WHERE a.patient_id = ?");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Assign fee for a specific test
    public function assignFeeForTest($patient_id, $test_id, $fee_amount, $status, $paid_at)
    {
        $stmt = $this->pdo->prepare("INSERT INTO bills (patient_id, test_type, amount, paid_at) VALUES (?, (SELECT test_name FROM tests WHERE id = ?), ?, ?)");
        $stmt->execute([$patient_id, $test_id, $fee_amount, $paid_at]);
    }
}
?>
<?php

class Bill {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a bill for a patient
    public function createBill($patientId, $testType, $amount) {
        $query = "INSERT INTO bills (patient_id, test_type, amount) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$patientId, $testType, $amount]);
        return $stmt->rowCount() > 0; // Returns true if the bill was successfully created
    }

    // Get all bills
    public function getAllBills() {
        $query = "SELECT p.name AS patient_name, b.test_type, b.amount, b.paid_at
                  FROM bills b JOIN users p ON b.patient_id = p.id";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total income (sum of all bills)
    public function getTotalIncome() {
        $query = "SELECT SUM(amount) AS total_income FROM bills";
        $stmt = $this->pdo->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_income'];
    }
}

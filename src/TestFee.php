<?php

class TestFee {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Assign fee for a test
    // public function assignFee($testType, $feeAmount) {
    //     $query = "INSERT INTO test_fees (test_type, fee_amount) VALUES (?, ?)";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->execute([$testType, $feeAmount]);
    //     return $stmt->rowCount() > 0; // Returns true if the fee was successfully added
    // }

    // // Get all test fees
    // public function getAllFees() {
    //     $query = "SELECT * FROM test_fees";
    //     $stmt = $this->pdo->query($query);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // // Get fee for a specific test type
    // public function getFeeByTestType($testType) {
    //     $query = "SELECT fee_amount FROM test_fees WHERE test_type = ?";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->execute([$testType]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
}

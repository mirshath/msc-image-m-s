<?php 
class TestFeeManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Add or Update Fee for a Test Type
    public function assignTestFee($test_type, $fee_amount)
    {
        // Check if the fee already exists
        $stmt = $this->pdo->prepare("SELECT id FROM test_fees WHERE test_type = ?");
        $stmt->execute([$test_type]);
        
        if ($stmt->rowCount() > 0) {
            // Update fee if it exists
            $stmt = $this->pdo->prepare("UPDATE test_fees SET fee_amount = ? WHERE test_type = ?");
            $stmt->execute([$fee_amount, $test_type]);
        } else {
            // Insert new fee if it doesn't exist
            $stmt = $this->pdo->prepare("INSERT INTO test_fees (test_type, fee_amount) VALUES (?, ?)");
            $stmt->execute([$test_type, $fee_amount]);
        }
    }
}

?>
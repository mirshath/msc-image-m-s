<?php
class Patient
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch all patients
    public function getAllPatients()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'patient' order by id desc ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Update a patient
    public function updatePatient($id, $name, $email)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $id]);
    }


   // Delete a patient
   public function deletePatient($id)
   {
       $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
       return $stmt->execute([$id]);
   }
}
?>
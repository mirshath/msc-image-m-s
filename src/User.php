<?php
class User
{
    private $pdo;

    // Constructor accepts the PDO object to interact with the database
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new user
    public function createUser($name, $email, $password, $role, $status = 'active')
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        return $stmt->execute([$name, $email, $hashedPassword, $role, $status]);
    }

    // Fetch user by email
    public function getUserByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user as an associative array
    }

    // Suspend or activate a user
    public function updateUserStatus($userId, $status)
    {
        // Validate the status
        if (!in_array($status, ['active', 'suspended'])) {
            return false; // Invalid status
        }

        // SQL query to update the user's status
        $query = "UPDATE users SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$status, $userId]);
    }

    // Get all users (for admin)
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all users as an associative array
    }

    // Verify if user is admin
    public function isAdmin($role)
    {
        return $role === 'admin';
    }
}
?>

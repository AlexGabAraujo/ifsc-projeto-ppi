<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

$userName = $_SESSION['user_name'] ?? 'Usuário';
$userProfile = $_SESSION['user_profile'] ?? 'comum';
$lastQuizScore = 0;
$userEmail = '';
$userPhone = '';
$userBirthDate = '';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    try {
        $stmt = $pdo->prepare("SELECT email, telefone, data_nascimento, last_quiz_score FROM usuario WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $userEmail = $result['email'];
            $userPhone = $result['telefone'];
            $userBirthDate = $result['data_nascimento'];
            $lastQuizScore = $result['last_quiz_score'];
        }
    } catch (\PDOException $e) {
        error_log("Error fetching user info: " . $e->getMessage());
    }
}

echo json_encode([
    'success' => true,
    'userName' => $userName,
    'userProfile' => $userProfile,
    'userEmail' => $userEmail,
    'userPhone' => $userPhone,
    'userBirthDate' => $userBirthDate,
    'lastQuizScore' => $lastQuizScore
]);
?>
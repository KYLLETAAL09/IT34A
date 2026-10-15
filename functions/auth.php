<?php

function loginUser($pdo, $login, $password) {
    $sql = "
        SELECT
            user_id,
            user_email,
            user_username,
            user_password,
            user_role
        FROM users
        WHERE user_email = :email
           OR user_username = :username
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $login,
        ':username' => $login
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    if (!password_verify($password, $user['user_password'])) {
        return false;
    }

    // Check if the user already has an active session
    if (hasActiveUserSession($pdo, $user['user_id'])) {
        return 'active_session';
    }

    // Prevent session fixation
    session_regenerate_id(true);

    // Session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_email'] = $user['user_email'];
    $_SESSION['user_username'] = $user['user_username'];
    $_SESSION['user_role'] = $user['user_role'];

    // Initialize session in database
    $_SESSION['session_id'] = startUserSession($pdo);

    return true;
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    }
}

function requireRole($role) {
    requireLogin();

    if ($_SESSION['user_role'] !== $role) {
        http_response_code(403);
        exit('Access Denied');
    }
}
?>
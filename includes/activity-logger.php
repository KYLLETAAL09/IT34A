<?php

function logActivity($pdo, $user_id, $email, $action, $status = 'success')
{
    try {
        // Get Client IP Address
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? 'Unknown';

        // Handle multiple IPs
        if (strpos($ip, ",") !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }

        // Get user agent
        $user_agent = substr(
            $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN',
            0,
            255
        );

        // Insert activity log
        $stmt = $pdo->prepare("
            INSERT INTO activity_logs (
                user_id,
                user_email,
                activity_log_action,
                activity_log_status,
                activity_log_ip_address,
                activity_log_user_agent
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        // Execute query
        $stmt->execute([
            $user_id,
            $email,
            $action,
            $status,
            $ip,
            $user_agent
        ]);

        return true;

    } catch (PDOException $e) {
        error_log("Activity Log Error: " . $e->getMessage());
        return false;
    }
}
?>

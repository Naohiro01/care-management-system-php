<?php
    session_start();
    if (isset($_SESSION['logged_in'])) {
        $_SESSION['last_activity'] = time();
    }
    echo json_encode(['ok => true']);
<?php
    session_start();
    header('Content-Type: application/json; charset=utf-8');

    // タイムアウト設定
    $timeout = 20;

    if (!isset($_SESSION['logged_in'])) {
        echo json_encode(['valid' => false]);
        exit;
    }

    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        echo json_encode(['valid' => false]);
        exit;
    }

    echo json_encode(['valid' => true]);
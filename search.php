<?php 
    session_start();
    require 'db.php';
    header('Content-Type: application/json; charset=utf8');

    if (!isset($_SESSION['logged_in'])) {
        http_response_code(401);
        echo json_encode(['error' => '未ログインです']);
        exit;
    }

    function getCareClass($care) {
        if(strpos($care, '要支援') !== false) return 'care-1';
        if(strpos($care, '1') !== false) return 'care-1';
        if(strpos($care, '2') !== false) return 'care-2';
        if(strpos($care, '3') !== false) return 'care-3';
        if(strpos($care, '4') !== false) return 'care-4';
        if(strpos($care, '5') !== false) return 'care-5';
        return '';
    }
    
    $keyword = $_GET['keyword']?? '';
    $care = $_GET['care']?? '';
    $gender = $_GET['gender']?? '';
    $staff = $_GET['staff']?? '';

    // SQL文の条件組み立て
    $sql = 'SELECT * FROM users WHERE 1=1';
    $params = [];

    if ($keyword !== '') {
        $sql .= ' AND (name LIKE ? OR kana LIKE ?)';
        $params[] = "%$keyword%";
        $params[] = "%$keyword%";
    }
    if ($care !== '') {
        $sql .= ' AND care_level = ?';
        $params[] = $care;
    }
    if ($gender !== '') {
        $sql .= ' AND gender = ?';
        $params[] = $gender;
    }
    if ($staff !== '') {
        $sql .= ' AND staff = ?';
        $params[] = $staff;
    }

    $sql .= ' ORDER BY id';
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute($params);
    $users = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // 各利用者データに介護度を付けて返す
    foreach($users as &$user) {
        $user['care_class'] =getCareClass($user['care_level']);
    }
    unset($user);

    echo json_encode($users);
<?php
    session_start();
    require 'db.php';

    // タイムアウト設定
    $timeout = 300;

    if (!isset($_SESSION['logged_in'])) {
        header('Location:login.php');
        exit;
    }

    if (time() - $_SESSION['last_activity'] > $timeout) {
            session_unset();
            session_destroy();
            header('Location:login.php?timeout=1');
            exit;
        }

    $_SESSION['last_activity'] = time();

    function getCareClass($care){
        if(strpos($care,'要支援') !== false)return 'care-1';
        if(strpos($care,'1') !== false)return 'care-1';
        if(strpos($care,'2') !== false)return 'care-2';
        if(strpos($care,'3') !== false)return 'care-3';
        if(strpos($care,'4') !== false)return 'care-4';
        if(strpos($care,'5') !== false)return 'care-5';
        return;
    }

    $id = $_GET['id'] ?? '';

    $stmt = $pdo -> prepare('SELECT * FROM users WHERE id = ?');
    $stmt -> execute([$id]);
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);

    //  該当なしで一覧に戻る
    if (!$user) {
        header('Location:index.php');
        exit;
    }

    $emergencyHtml = str_replace(')', ')<br>', htmlspecialchars($user['emergency']));
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用者詳細</title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">

    <!-- リセットcss -->
    <link rel="stylesheet" href="https://unpkg.com">
    <!-- css読込 -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="app-page">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <span>CMS</span>
            <p>利用者管理</p>
        </div><!-- sidebar-logo -->
        <nav class="sidebar-nav">
            <a href="index.php" title="利用者一覧">
                <span class="material-symbols-outlined">group</span>
                <span class="nav-label">利用者一覧</span>
            </a>
            <a href="logout.php" title="ログアウト">
                <span class="material-symbols-outlined">logout</span>
                <span class="nav-label">ログアウト</span>
            </a>
        </nav><!-- .sidebar-nav -->
    </aside><!-- .sidebar -->

    <main class="MN">
        <header class="app-header">
            <h2>利用者詳細</h2>
            <span class="header-user">
                <span class="material-symbols-outlined">account_circle</span>
                <?= 
                    htmlspecialchars($_SESSION['username'])
                ?>
            </span><!-- .header-user -->
        </header><!-- .app-header -->
        <div class="detail-wrap">
            <a href="index.php" class="btn-back">← 一覧に戻る</a>
            <div class="detail-card">
                <div class="detail-header">
                    <div class="detail-avatar">
                        <span class="material-symbols-outlined">person</span>
                    </div><!-- .detail-avatar -->
                    <div>
                        <h3><?= htmlspecialchars($user['name']) ?></h3>
                        <p><?= htmlspecialchars($user['kana']) ?></p>
                        <span class="care-badge <?= getCareClass($user['care_level']) ?>"><?= htmlspecialchars($user['care_level']) ?></span>
                    </div>
                </div><!-- .detail-header -->
            
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">利用者ID</div>
                        <div class="detail-value"><?= htmlspecialchars($user['id']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">年齢</div>
                        <div class="detail-value"><?= htmlspecialchars($user['age']) ?>歳</div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">性別</div>
                        <div class="detail-value"><?= htmlspecialchars($user['gender']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">生年月日</div>
                        <div class="detail-value"><?= htmlspecialchars($user['birth']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">住所</div>
                        <div class="detail-value"><?= htmlspecialchars($user['address']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">電話番号</div>
                        <div class="detail-value"><?= htmlspecialchars($user['tel']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">緊急連絡先</div>
                        <div class="detail-value"><?= $emergencyHtml ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">担当者</div>
                        <div class="detail-value"><?= htmlspecialchars($user['staff']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">利用開始日</div>
                        <div class="detail-value"><?= htmlspecialchars($user['start_date']) ?></div>
                    </div><!-- .detail-item -->
                    <div class="detail-item">
                        <div class="detail-label">利用曜日</div>
                        <div class="detail-value"><?= htmlspecialchars($user['days']) ?></div>
                    </div><!-- .detail-item -->
                </div><!-- .detail-grid -->

                <div class="detail-note">
                    <div class="detail-label">備考･特記事項</div>
                    <div class="detail-value"><?= nl2br(htmlspecialchars($user['note'])) ?></div>
                </div><!-- .detail-note -->
            </div><!-- .detail-card -->
        </div><!-- .detail-wrap -->
    </main><!-- .MN -->
</body>
</html>
<?php
    session_start();
    require 'db.php';

    // タイムアウト設定
    $timeout = 20;
    // 未ログインならログイン画面へ
    if (!isset($_SESSION['logged_in'])) {
        header('Location:login.php');
        exit;
    }
    
    // if (time() - $_SESSION['last_activity'] > $timeout) {
    //     session_unset();
    //     session_destroy();
    //     header('Location:login.php?timeout=1');
    //     exit;
    // }

    $_SESSION['last_activity'] = time();

    // 介護度の判定
    function getCareClass($care) {
        if (strpos($care, '要支援')!== false) return 'care-1'; 
        if (strpos($care, '1')!== false) return 'care-1'; 
        if (strpos($care, '2')!== false) return 'care-2'; 
        if (strpos($care, '3')!== false) return 'care-3'; 
        if (strpos($care, '4')!== false) return 'care-4'; 
        if (strpos($care, '5')!== false) return 'care-5'; 
        return '';            
    }

    // 全件取得
    $stmt = $pdo -> query('SELECT*FROM users ORDER BY id');
    $users = $stmt -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用者一覧</title>

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
        </div><!-- .sidebar-logo -->
        <nav class="sidebar-nav">
            <a href="index.php" class="active" title="利用者一覧">
            <span class="material-symbols-outlined">group</span>
            <span class="nav-label">利用者一覧</span>
            </a><!-- .active -->
            <a href="logout.php" title="ログアウト">
            <span class="material-symbols-outlined">logout</span>
            <span class="nav-label">ログアウト</span>
            </a>
        </nav><!-- .sidebar-nav -->
    </aside><!-- .sidebar -->

    <main class="MN">
        <header class="appheader">
            <h2>利用者一覧</h2>
            <span class="header-user">
                <span class="material-symbols-outlined">account_circle</span>
                <?=
                    htmlspecialchars($_SESSION['username'])
                ?>            
            </span><!-- .header-user -->
        </header>

        <div class="search-bar">
            <input type="text" id="search-input" placeholder="名前・ふりがなで検索...">
            <select id="care-filter">
                <option value="">すべての介護度</option>
                <option value="要支援1">要支援1</option>
                <option value="要支援2">要支援2</option>
                <option value="要介護1">要介護1</option>
                <option value="要介護2">要介護2</option>
                <option value="要介護3">要介護3</option>
                <option value="要介護4">要介護4</option>
                <option value="要介護5">要介護5</option>
            </select><!-- #care-filter -->
            <select id="gender-filter">
                <option value="">すべての性別</option>
                <option value="男性">男性</option>
                <option value="女性">女性</option>
            </select><!-- #gender-filter -->
            <select id="staff-filter">
                <option value="">すべての担当者</option>
                <option value="田中 美咲">田中 美咲</option>
                <option value="伊藤 良子">伊藤 良子</option>
                <option value="鈴木 健太">鈴木 健太</option>
            </select><!-- #staff-filter -->
            <button class="btn-search" id="search-btn">検索</button>
            <button class="btn-search" id="reset-btn">リセット</button>
        </div><!-- .search-bar -->
        <p class="result-count"><?= count($users) ?>件表示中</p>

        <div class="table-wrap">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>氏名</th>
                        <th>ふりがな</th>
                        <th>年齢</th>
                        <th>性別</th>
                        <th>介護度</th>
                        <th>担当者</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    <?php foreach($users as $user):?>
                        <tr>
                            <td><?=
                                htmlspecialchars($user['id'])
                            ?></td>
                            <td><strong><?= 
                                htmlspecialchars($user['name'])
                            ?></strong></td>
                            <td><?= 
                                htmlspecialchars($user['kana'])
                            ?></td>
                            <td><?= 
                                htmlspecialchars($user['age'])
                            ?>歳</td>
                            <td><?= 
                                htmlspecialchars($user['gender'])
                            ?></td>
                            <td><span class="care-badge <?= getCareClass($user['care_level']) ?>"><?= 
                                htmlspecialchars($user['care_level'])
                            ?></span></td>
                            <td><?= 
                                htmlspecialchars($user['staff'])
                            ?></td>
                            <td><a href="detail.php?id=<?= $user['id'] ?>" class="btn-detail">詳細</a></td>
                        </tr>
                        <?php endforeach; ?>
                </tbody><!-- #user-table-body -->
            </table><!-- .user-table -->
        </div><!-- .table-wrap -->
    </main><!-- .MN -->
    
    <script>
        async function searchUsers() {
            const keyword = document.getElementById('search-input').value.trim();
            const care = document.getElementById('care-filter').value;
            const gender = document.getElementById('gender-filter').value;
            const staff = document.getElementById('staff-filter').value;

            const params = new URLSearchParams({keyword,care,gender,staff});
            const res = await fetch('search.php?'+params.toString());
            const users = await res.json();

            renderTable(users);
        }

        function renderTable(users) {
            const tbody = document.getElementById('user-table-body');
            tbody.innerHTML = '';
            document.querySelector('.result-count').textContent = users.length + '件表示中';

            if (users.length === 0) {
                tbody.innerHTML = '<tr><td colspan = "8" style = "text-align:center;padding:2rem;color:#64748b;">該当する利用者が見つかりません</td></tr>';
                return;
            }

            users.forEach(user => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>${user.id}</td>
                <td><strong>${user.name}</strong></td>
                <td>${user.kana}</td>
                <td>${user.age}歳</td>
                <td>${user.gender}</td>
                <td><span class="care-badge ${user.care_class}">${user.care_level}</span></td>
                <td>${user.staff}</td>
                <td><a href="detail.php?id=${user.id}" class="btn-detail">詳細</a></td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.getElementById('search-btn').addEventListener('click', searchUsers);
        document.getElementById('reset-btn').addEventListener('click', () => {
            document.getElementById('search-input').value = '';
            document.getElementById('care-filter').value = '';
            document.getElementById('gender-filter').value = '';
            document.getElementById('staff-filter').value = '';
            searchUsers();
        });

         setInterval(async() => {
            const res = await fetch('session-check.php');
            const data = await res.json();
            if (!data.valid) {
                alert('セッションがタイムアウトしました。再度ログインしてください。');
                window.location.href = 'login.php?timeout=1';
            }
        }, 30000);

        // ユーザー操作を検知したらサーバーに活動時刻を伝える
        let activityTimer = null;
        function notifyActivity() {
            clearTimeout(activityTimer);
            activityTimer = setTimeout(() => {
                fetch('update-activity.php');
            }, 1000); //操作が1秒落ち着いたら送信(連打防止)
        }

        document.addEventListener('click', notifyActivity);
        document.addEventListener('keydown', notifyActivity);
    </script>

</body>
</html>
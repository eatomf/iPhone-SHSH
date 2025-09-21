<?php
require_once 'config.php';
require_once 'models.php';
require_once 'theme.php';

$selectedModel = $_POST['model'] ?? '';
$selectedType = '';

if ($selectedModel) {
    if (strpos($selectedModel, 'iPhone') === 0) $selectedType = 'iPhone';
    elseif (strpos($selectedModel, 'iPad')  === 0) $selectedType = 'iPad';
    elseif (strpos($selectedModel, 'iPod')  === 0) $selectedType = 'iPod';
    elseif (strpos($selectedModel, 'Watch') === 0) $selectedType = 'Watch';
}

$ecid  = $_POST['intecid']   ?? '';
$model = $_POST['post_model'] ?? '';
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SHSH Checker | iOS 固件签名查询</title>
    <script src="./3des.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <link rel="icon" href="/Macintosh.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="theme-<?php echo $theme; ?>">
    <?php include 'header.php'; ?>
    
    <script>
        function post_encrypt_data() {
            const hexecid = document.getElementById('ecid').value;
            const ecid    = parseInt(hexecid, 16);
            const model   = document.getElementById('model').value;
            const obj     = { ecid: ecid, model: model, time: Date.now() };
            const param   = encrypt_3DES(JSON.stringify(obj), '2015aisi1234sj7890smartflashi4pc', 0, 1, 0);
            document.getElementById('encrypt_param').value = param;
            document.getElementById('intecid').value       = ecid;
            document.getElementById('post_model').value    = model;
        }
        
        function toggleTheme() {
            const currentTheme = '<?php echo $theme; ?>';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            window.location.href = '?theme=' + newTheme;
        }
    </script>

    <?php include 'form.php'; ?>
    
    <?php if ($ecid && $model): ?>
        <?php include 'results.php'; ?>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
    
    <!-- 底部主题切换按钮 -->
    <div class="theme-toggle-container">
        <button class="theme-toggle-btn <?php echo $theme; ?>" onclick="toggleTheme()">
            <?php if ($theme === 'dark'): ?>
                🌙 深色模式
            <?php else: ?>
                ☀️ 浅色模式
            <?php endif; ?>
        </button>
    </div>

    <?php include 'scripts.php'; ?>
</body>
</html>
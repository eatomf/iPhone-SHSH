<?php
/* ---------- 回显 & 型号表 ---------- */
$selectedModel = $_POST['model'] ?? '';
$selectedType  = '';

if ($selectedModel) {
    if (strpos($selectedModel, 'iPhone') === 0) $selectedType = 'iPhone';
    elseif (strpos($selectedModel, 'iPad')  === 0) $selectedType = 'iPad';
    elseif (strpos($selectedModel, 'iPod')  === 0) $selectedType = 'iPod';
    elseif (strpos($selectedModel, 'Watch') === 0) $selectedType = 'Watch';
}

$ecid  = $_POST['intecid']   ?? '';
$model = $_POST['post_model'] ?? '';

$modelMap = [
    'iPhone' => [
        'iPhone1,1',  'iPhone2,1',  'iPhone3,1',  'iPhone3,2',  'iPhone3,3',  'iPhone4,1',
        'iPhone5,1',  'iPhone5,2',  'iPhone5,3',  'iPhone5,4',  'iPhone6,1',  'iPhone6,2',
        'iPhone7,1',  'iPhone7,2',  'iPhone8,1',  'iPhone8,2',  'iPhone8,4',  'iPhone9,1',
        'iPhone9,2',  'iPhone9,3',  'iPhone9,4',  'iPhone10,1', 'iPhone10,2', 'iPhone10,3',
        'iPhone10,4', 'iPhone10,5', 'iPhone10,6', 'iPhone11,2', 'iPhone11,4', 'iPhone11,6',
        'iPhone11,8', 
    ],
    'iPad' => [
        'iPad1,1',  'iPad2,1',  'iPad2,2',  'iPad2,3',  'iPad2,4',  'iPad2,5',  'iPad2,6',  'iPad2,7',
        'iPad3,1',  'iPad3,2',  'iPad3,3',  'iPad3,4',  'iPad3,5',  'iPad3,6',  'iPad4,1',  'iPad4,2',
        'iPad4,3',  'iPad4,4',  'iPad4,5',  'iPad4,6',  'iPad4,7',  'iPad4,8',  'iPad4,9',
        'iPad5,1',  'iPad5,2',  'iPad5,3',  'iPad5,4',  'iPad6,11', 'iPad6,12',
    ],
    'iPod' => [
        'iPod2,1', 'iPod3,1', 'iPod4,1', 'iPod5,1', 'iPod6,1', 'iPod7,1',
    ],
    'Watch' => [
        'Watch1,1', 'Watch1,2', 'Watch2,3',
    ],
];

/* ---------- 友好名称映射 ---------- */
$modelNames = [
    'iPhone1,1'  => 'iPhone 2G',        'iPhone2,1'  => 'iPhone 3G',
    'iPhone3,1'  => 'iPhone 4',         'iPhone3,2'  => 'iPhone 4(REVA)',
    'iPhone3,3'  => 'iPhone 4(CDMA)',   'iPhone4,1'  => 'iPhone 4S',
    'iPhone5,1'  => 'iPhone 5[GSM]',    'iPhone5,2'  => 'iPhone 5',
    'iPhone5,3'  => 'iPhone 5c',        'iPhone5,4'  => 'iPhone 5c',
    'iPhone6,1'  => 'iPhone 5s[GSM]',   'iPhone6,2'  => 'iPhone 5s',
    'iPhone7,1'  => 'iPhone 6 Plus',    'iPhone7,2'  => 'iPhone 6',
    'iPhone8,1'  => 'iPhone 6s',        'iPhone8,2'  => 'iPhone 6s Plus',
    'iPhone8,4'  => 'iPhone SE',        'iPhone9,1'  => 'iPhone 7',
    'iPhone9,2'  => 'iPhone 7 Plus',    'iPhone9,3'  => 'iPhone 7',
    'iPhone9,4'  => 'iPhone 7 Plus',    'iPhone10,1' => 'iPhone 8',
    'iPhone10,2' => 'iPhone 8 Plus',    'iPhone10,3' => 'iPhone X',
    'iPhone10,4' => 'iPhone 8',         'iPhone10,5' => 'iPhone 8 Plus',
    'iPhone10,6' => 'iPhone X',         'iPhone11,2' => 'iPhone XS',
    'iPhone11,4' => 'iPhone XS Max',    'iPhone11,6' => 'iPhone XS Max',
    'iPhone11,8' => 'iPhone XR',       

    'iPad1,1'  => 'iPad 1',          'iPad2,1'  => 'iPad 2',
    'iPad2,2'  => 'iPad 2',         'iPad2,3'  => 'iPad 2',
    'iPad2,4'  => 'iPad 2',         'iPad2,5'  => 'iPad mini',
    'iPad2,6'  => 'iPad mini',      'iPad2,7'  => 'iPad mini',
    'iPad3,1'  => 'iPad 3',         'iPad3,2'  => 'iPad 3',
    'iPad3,3'  => 'iPad 3',         'iPad3,4'  => 'iPad 4',
    'iPad3,5'  => 'iPad 4',         'iPad3,6'  => 'iPad 4',
    'iPad4,1'  => 'iPad Air',       'iPad4,2'  => 'iPad Air',
    'iPad4,3'  => 'iPad Air',       'iPad4,4'  => 'iPad mini 2',
    'iPad4,5'  => 'iPad mini 2',    'iPad4,6'  => 'iPad mini 2',
    'iPad4,7'  => 'iPad mini 3',    'iPad4,8'  => 'iPad mini 3',
    'iPad4,9'  => 'iPad mini 3',    'iPad5,1'  => 'iPad mini 4',
    'iPad5,2'  => 'iPad mini 4',    'iPad5,3'  => 'iPad Air 2',
    'iPad5,4'  => 'iPad Air 2',     'iPad6,11' => 'iPad 5',
    'iPad6,12' => 'iPad 5',

    'iPod2,1' => 'iPod touch 2',    'iPod3,1' => 'iPod touch 3',
    'iPod4,1' => 'iPod touch 4',    'iPod5,1' => 'iPod touch 5',
    'iPod6,1' => 'iPod touch 6',    'iPod7,1' => 'iPod touch 7',

    'Watch1,1' => 'Apple Watch Series [38MM]',   'Watch1,2' => 'Apple Watch Series [42MM]',
    'Watch2,3' => 'Apple Watch Series 2[38MM]',
];

// 处理主题切换
$theme = $_COOKIE['theme'] ?? 'dark';
if (isset($_GET['theme'])) {
    $theme = in_array($_GET['theme'], ['light', 'dark']) ? $_GET['theme'] : 'dark';
    setcookie('theme', $theme, time() + (86400 * 30), "/"); // 30天
    header('Location: ' . str_replace(['?theme=light', '?theme=dark'], '', $_SERVER['REQUEST_URI']));
    exit;
}
?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SHSH Checker | iOS 固件签名查询</title>
    <script src="./3des.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <link rel="icon" href="/Macintosh.png" type="image/png">
    <style>
        :root {
            --color-bg: #0A2540;
            --color-bg-light: #1A3A5F;
            --color-accent: #4ECDC4;
            --color-accent-light: #7BE0D9;
            --color-text: #FFFFFF;
            --color-text-muted: rgba(255,255,255,.85);
            --radius: 16px;
            --spacing: 2rem;
            --mobile-spacing: 1rem;
            --card-bg: rgba(255, 255, 255, 0.08);
            --card-border: rgba(255,255,255,.12);
            --input-bg: rgba(255,255,255,.1);
            --input-border: rgba(255,255,255,.2);
            --empty-state-bg: rgba(255,255,255,.05);
            --empty-state-text: rgba(255,255,255,.7);
            --version-tag-bg: rgba(78, 205, 196, 0.15);
            --version-tag-border: rgba(78, 205, 196, 0.3);
            --version-tag-text: #7BE0D9;
        }

        .theme-light {
            --color-bg: #F0F8FF;
            --color-bg-light: #FFFFFF;
            --color-accent: #5AC8FA;
            --color-accent-light: #7AD9FF;
            --color-text: #1D2D35;
            --color-text-muted: #4A5C66;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-border: rgba(90, 200, 250, 0.2);
            --input-bg: rgba(255, 255, 255, 0.8);
            --input-border: rgba(90, 200, 250, 0.3);
            --empty-state-bg: rgba(90, 200, 250, 0.1);
            --empty-state-text: #5A6C76;
            --version-tag-bg: rgba(90, 200, 250, 0.15);
            --version-tag-border: rgba(90, 200, 250, 0.3);
            --version-tag-text: #2A7C9C;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, var(--color-bg) 0%, var(--color-bg-light) 100%);
            color: var(--color-text);
            min-height: 100vh;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: background 0.3s ease, color 0.3s ease;
            position: relative;
            padding-bottom: 80px; /* 为底部按钮留出空间 */
        }
        .header { 
            text-align: center; 
            margin: 1rem 0 2rem; 
            max-width: 600px; 
            width: 100%; 
        }
        .logo {
            font-size: clamp(2rem, 8vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -.02em;
            text-shadow: 2px 2px 12px rgba(0,0,0,.2);
            background: linear-gradient(45deg, var(--color-accent), var(--color-accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: .5rem;
        }
        .tagline { 
            font-size: clamp(0.9rem, 3vw, 1.1rem); 
            opacity: .85; 
            padding: 0 0.5rem;
            color: var(--color-text-muted);
        }
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border-radius: var(--radius);
            box-shadow: 0 12px 32px rgba(0,0,0,.15);
            padding: 1.5rem;
            width: 100%;
            margin-bottom: var(--mobile-spacing);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }
        @media (min-width: 768px) {
            body { padding: 2rem; padding-bottom: 80px; }
            .card {
                padding: 2.5rem;
                margin-bottom: var(--spacing);
            }
            .header { margin: 2rem 0 3rem; }
        }
        .card { max-width: 720px !important; }
        .card-title { 
            font-size: 1.5rem !important; 
            margin-bottom: 1.5rem;
            color: var(--color-accent);
        }
        @media (min-width: 768px) {
            .card-title { font-size: 2rem !important; }
        }
        select.form-control { 
            border-radius: var(--radius);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            background: var(--color-accent);
            color: white;
            font-weight: 600;
            padding: 1em 2em;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            transition: all .25s ease;
            width: 100%;
            margin-top: .5rem;
            font-size: 1.1em;
            letter-spacing: .5px;
            min-height: 54px;
        }
        .btn:hover, .btn:active { 
            background: var(--color-accent-light); 
            transform: translateY(-2px); 
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        .form-group { margin-bottom: 1.25rem; }
        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: var(--radius);
            color: var(--color-text);
            padding: 1rem 1.2rem;
            width: 100%;
            font-size: 1rem;
            transition: all .2s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%235AC8FA' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px;
            padding-right: 2.8rem;
            min-height: 54px;
        }
        .form-control:focus {
            background: var(--input-bg);
            border-color: var(--color-accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(90, 200, 250, 0.2);
        }
        select.form-control option {
            background: var(--color-bg-light);
            color: var(--color-text);
            border-radius: 8px;
            margin: .25rem 0;
            padding: 0.5rem;
        }
        .form-label { 
            display: block; 
            margin-bottom: .5rem; 
            color: var(--color-text-muted); 
            font-weight: 500; 
            font-size: 1rem;
        }
        .result-section { margin-top: 1rem; }
        .source-label { 
            font-weight: 600; 
            color: var(--color-accent); 
            margin-bottom: 1rem; 
            display: inline-block; 
            font-size: 1.1rem;
        }
        .version-list { 
            display: flex; 
            flex-wrap: wrap; 
            gap: .6rem; 
            margin-top: 1rem; 
        }
        .version-tag { 
            background: var(--version-tag-bg); 
            padding: .5rem .8rem; 
            border-radius: 30px; 
            font-size: .85rem; 
            border: 1px solid var(--version-tag-border); 
            color: var(--version-tag-text);
        }
        .empty-state { 
            padding: 1.2rem; 
            text-align: center; 
            background: var(--empty-state-bg); 
            border-radius: var(--radius); 
            color: var(--empty-state-text); 
            font-size: 0.95rem;
        }
        footer { 
            margin: 2rem 0 1rem; 
            font-size: .8rem; 
            opacity: .7; 
            text-align: center; 
            padding: 0 0.5rem;
        }
        footer a { color: var(--color-accent); text-decoration: none; }
        footer a:hover { color: var(--color-accent-light); text-decoration: underline; }
        
        /* 底部主题切换按钮 */
        .theme-toggle-container {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: flex;
            justify-content: center;
            width: 100%;
        }
        
        .theme-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            min-width: 160px;
        }
        
        .theme-toggle-btn.dark {
            background: linear-gradient(145deg, #1A3A5F, #0A2540);
            color: #4ECDC4;
            border: 1px solid rgba(78, 205, 196, 0.3);
        }
        
        .theme-toggle-btn.light {
            background: linear-gradient(145deg, #5AC8FA, #7AD9FF);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .theme-toggle-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
        
        .theme-toggle-btn:active {
            transform: translateY(1px);
        }
        
        @media (max-width: 480px) {
            .card { padding: 1.2rem; }
            .form-control {
                padding: 0.9rem 1rem;
                font-size: 16px;
            }
            .btn {
                padding: 0.9em 1.5em;
                min-height: 50px;
            }
            .version-list { gap: 0.5rem; }
            .version-tag {
                padding: 0.4rem 0.7rem;
                font-size: 0.8rem;
            }
            
            .theme-toggle-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
                min-width: 140px;
            }
        }
    </style>
</head>
<body class="theme-<?php echo $theme; ?>">
    <div class="header">
        <h1 class="logo">SHSH Checker</h1>
        <p class="tagline">查询iOS设备的SHSH备份状态，支持多源验证</p>
    </div>

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

    <div class="card">
        <h3 class="card-title">设备信息</h3>
        <form action="" method="post" onsubmit="post_encrypt_data()">
            <input type="hidden" id="encrypt_param" name="encrypt_param">
            <input type="hidden" id="intecid" name="intecid">
            <input type="hidden" id="post_model" name="post_model">

            <div class="form-group">
                <label for="ecid" class="form-label">ECID (十六进制)</label>
                <input type="text" class="form-control" id="ecid" placeholder="例如: 0000001C01087D74" name="ecid" value="<?= htmlspecialchars($_POST['ecid'] ?? '') ?>" inputmode="text">
            </div>

            <div class="form-group">
                <label for="deviceType" class="form-label">设备类型</label>
                <select id="deviceType" class="form-control">
                    <option value="">请选择设备类型</option>
                    <?php foreach (array_keys($modelMap) as $type): ?>
                        <option value="<?= $type ?>" <?= $selectedType === $type ? 'selected' : '' ?>>
                            <?= $type === 'Watch' ? 'Apple Watch' : $type ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="model" class="form-label">具体型号</label>
                <select id="model" name="model" class="form-control" <?= $selectedType ? '' : 'disabled' ?>>
                    <option value="">请选择具体型号</option>
                    <?php if ($selectedType):
                        foreach ($modelMap[$selectedType] as $m): ?>
                            <option value="<?= $m ?>" <?= $m === $selectedModel ? 'selected' : '' ?>>
                                <?= ($modelNames[$m] ?? $m) . ' (' . $m . ')' ?>
                            </option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>

            <button type="submit" class="btn">查询SHSH状态</button>
        </form>
    </div>

    <?php if ($ecid && $model): ?>
    <div class="card result-section">
        <?php
        $cydia_url  = 'https://cydia.saurik.com/tss@home/api/check/';
        $cydia_data = @json_decode(@file_get_contents($cydia_url . $ecid), true);
        echo "<span class='source-label'>Cydia 服务器</span>";
        if ($cydia_data) {
            $versions = [];
            foreach ($cydia_data as $item) {
                if (($item['model'] ?? '') === $model) {
                    $versions[] = $item['firmware'] . ' (' . $item['build'] . ')';
                }
            }
            if ($versions) {
                echo "<div class='version-list'>";
                foreach ($versions as $v) echo "<span class='version-tag'>$v</span>";
                echo "</div>";
            } else {
                echo "<div class='empty-state'>未查询到该设备的SHSH备份</div>";
            }
        } else {
            echo "<div class='empty-state'>查询失败或无结果</div>";
        }
        ?>
    </div>

    <div class="card result-section">
        <?php
        $encrypt_param = $_POST['encrypt_param'] ?? '';
        if ($encrypt_param) {
            $i4_url  = 'https://i4tool2.i4.cn/requestBackupSHSHList.xhtml?param=';
            $i4_data = @json_decode(@file_get_contents($i4_url . urlencode($encrypt_param)), true);
            echo "<span class='source-label'>爱思服务器</span>";
            if (isset($i4_data['list']) && is_array($i4_data['list'])) {
                $versions = [];
                foreach ($i4_data['list'] as $item) $versions[] = ($item['ios'] ?? '');
                if ($versions) {
                    echo "<div class='version-list'>";
                    foreach ($versions as $v) echo "<span class='version-tag'>$v</span>";
                    echo "</div>";
                } else {
                    echo "<div class='empty-state'>未查询到该设备的SHSH备份</div>";
                }
            } else {
                echo "<div class='empty-state'>查询失败或无结果</div>";
            }
        }
        ?>
    </div>
    <?php endif; ?>

    <footer>
        <p>Powered by <a href="https://github.com/j1ans/SHSHChecker" target="_blank">SHSH Checker</a></p>
    </footer>

    <!-- 底部主题切换按钮 -->
    <div class="theme-toggle-container">
        <button class="theme-toggle-btn <?php echo $theme; ?>" onclick="toggleTheme()">
            <?php if ($theme === 'dark'): ?>
                暗 深色模式
            <?php else: ?>
                亮 浅色模式
            <?php endif; ?>
        </button>
    </div>

    <script>
        const modelMap = <?= json_encode($modelMap, JSON_UNESCAPED_SLASHES) ?>;
        const modelNames = <?= json_encode($modelNames, JSON_UNESCAPED_SLASHES) ?>;
        const deviceTypeSelect = document.getElementById('deviceType');
        const modelSelect = document.getElementById('model');

        deviceTypeSelect.addEventListener('change', function () {
            const type = this.value;
            modelSelect.innerHTML = '<option value="">请选择具体型号</option>';
            modelSelect.disabled = !type;
            if (!type) return;
            
            modelMap[type].forEach(m => {
                const name = (modelNames[m] ?? m) + ' (' + m + ')';
                const opt = new Option(name, m);
                modelSelect.add(opt);
            });
        });

        if (deviceTypeSelect.value) deviceTypeSelect.dispatchEvent(new Event('change'));
        
        document.querySelector('form').addEventListener('submit', function(e) {
            const ecid = document.getElementById('ecid').value;
            const model = document.getElementById('model').value;
            
            if (!ecid || !model) {
                e.preventDefault();
                alert('请填写完整的设备信息');
                return false;
            }
        });
    </script>
</body>
</html>
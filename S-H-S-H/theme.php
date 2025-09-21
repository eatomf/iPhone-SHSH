<?php
// 处理主题切换
$theme = $_COOKIE['theme'] ?? 'dark';
if (isset($_GET['theme'])) {
    $theme = in_array($_GET['theme'], ['light', 'dark']) ? $_GET['theme'] : 'dark';
    setcookie('theme', $theme, time() + (86400 * 30), "/"); // 30天
    header('Location: ' . str_replace(['?theme=light', '?theme=dark'], '', $_SERVER['REQUEST_URI']));
    exit;
}
?>
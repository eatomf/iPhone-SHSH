<?php
// Cydia 服务器查询
$cydia_data = @json_decode(@file_get_contents(CYDIA_URL . $ecid), true);
?>
<div class="card result-section">
    <span class='source-label'>Cydia 服务器</span>
    <?php if ($cydia_data): 
        $versions = [];
        foreach ($cydia_data as $item) {
            if (($item['model'] ?? '') === $model) {
                $versions[] = $item['firmware'] . ' (' . $item['build'] . ')';
            }
        }
        if ($versions): ?>
            <div class='version-list'>
                <?php foreach ($versions as $v): ?>
                    <span class='version-tag'><?= $v ?></span>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class='empty-state'>未查询到该设备的SHSH备份</div>
        <?php endif; ?>
    <?php else: ?>
        <div class='empty-state'>查询失败或无结果</div>
    <?php endif; ?>
</div>

<?php
// 爱思服务器查询
$encrypt_param = $_POST['encrypt_param'] ?? '';
if ($encrypt_param):
    $i4_data = @json_decode(@file_get_contents(I4_URL . urlencode($encrypt_param)), true);
?>
<div class="card result-section">
    <span class='source-label'>爱思服务器</span>
    <?php if (isset($i4_data['list']) && is_array($i4_data['list'])): 
        $versions = [];
        foreach ($i4_data['list'] as $item) $versions[] = ($item['ios'] ?? '');
        if ($versions): ?>
            <div class='version-list'>
                <?php foreach ($versions as $v): ?>
                    <span class='version-tag'><?= $v ?></span>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class='empty-state'>未查询到该设备的SHSH备份</div>
        <?php endif; ?>
    <?php else: ?>
        <div class='empty-state'>查询失败或无结果</div>
    <?php endif; ?>
</div>
<?php endif; ?>
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
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
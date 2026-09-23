<?php
/*
Template Name: Промокоды
*/
get_header();
?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<style>
.promo-wrap{max-width:820px;}
.promo-intro{font-size:15px;line-height:1.7;color:#555;margin-bottom:28px;}
.promo-operator{margin-bottom:36px;}
.promo-operator-head{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-bottom:14px;flex-wrap:wrap;}
.promo-operator-name{font-size:20px;font-weight:700;margin:0;}
.promo-operator-go{display:inline-block;background:#0e920e;color:#fff!important;text-decoration:none!important;padding:8px 18px;border-radius:6px;font-size:14px;font-weight:600;}
.promo-code-list{display:flex;flex-direction:column;gap:12px;}
.promo-code-card{background:#f5f5f5;border-radius:10px;padding:16px 18px;}
.promo-code-desc{font-size:14px;color:#333;margin-bottom:10px;line-height:1.5;}
.promo-code-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.promo-code-box{background:#fff;border:2px dashed #0e920e;border-radius:6px;padding:6px 14px;font-weight:700;font-size:16px;letter-spacing:1px;cursor:pointer;}
.promo-code-expires{font-size:12px;color:#999;}
@media screen and (max-width:480px){
.promo-operator-head{flex-direction:column;align-items:flex-start;}
.promo-operator-go{width:100%;box-sizing:border-box;text-align:center;}
}
</style>

<div class="block_left">
    <?php if (function_exists('include') ) { @include('sn_breadcrumbs.php'); } ?>

    <div class="promo-wrap">
        <h1>Промокоды на билеты на концерты</h1>
        <div class="promo-intro">
            Здесь мы держим под рукой рабочие промокоды крупнейших билетных сервисов — тех же, через которые вы покупаете билеты на нашем сайте. Список сверяем регулярно: если оператор меняет условия или код перестаёт действовать, обновляем запись. Просто скопируйте нужный код и вставьте его при оформлении заказа на сайте оператора.
        </div>

        <?php
        $promo_cache_key = 'gigsbot_promo_codes';
        $promo_data = get_transient($promo_cache_key);
        if ($promo_data === false) {
            $presp = wp_remote_get('https://tcket.ru/api/promo', ['timeout' => 8]);
            $promo_data = [];
            if (!is_wp_error($presp)) {
                $pdata = json_decode(wp_remote_retrieve_body($presp), true);
                if (!empty($pdata)) {
                    $promo_data = $pdata;
                }
            }
            if (!empty($promo_data)) {
                set_transient($promo_cache_key, $promo_data, HOUR_IN_SECONDS * 6);
            }
        }

        $promo_own_links = [
            'yandex' => 'https://fas.st/UdLjCv?erid=25H8d7vbP8SRTvHZrUcdLB',
            'kassir' => 'https://fas.st/0klFO?erid=25H8d7vbP8SRTvFaSMM9uC',
        ];

        foreach ($promo_data as $op_key => $operator):
            if (empty($operator['codes'])) continue;
            $op_link = $promo_own_links[$op_key] ?? ($operator['url'] ?? '#');
        ?>
        <div class="promo-operator">
            <div class="promo-operator-head">
                <h2 class="promo-operator-name"><?php echo esc_html($operator['name']); ?></h2>
                <a class="promo-operator-go" href="<?php echo esc_url($op_link); ?>" rel="nofollow sponsored" target="_blank">Перейти на сайт →</a>
            </div>
            <div class="promo-code-list">
                <?php foreach ($operator['codes'] as $pc): ?>
                <div class="promo-code-card">
                    <div class="promo-code-desc"><?php echo esc_html($pc['description']); ?></div>
                    <div class="promo-code-row">
                        <span class="promo-code-box" onclick="navigator.clipboard.writeText('<?php echo esc_js($pc['code']); ?>'); this.textContent='Скопировано ✓'; setTimeout(()=>{this.textContent='<?php echo esc_js($pc['code']); ?>';}, 2000);"><?php echo esc_html($pc['code']); ?></span>
                        <?php if (!empty($pc['expires'])): ?>
                        <span class="promo-code-expires">Действует до <?php echo esc_html($pc['expires']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($promo_data)): ?>
        <div class="ticket_no">Не удалось загрузить промокоды, попробуйте обновить страницу позже.</div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

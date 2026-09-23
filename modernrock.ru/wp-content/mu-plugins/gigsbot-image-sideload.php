<?php
/*
Plugin Name: GigsBot Image Sideload Tool
Description: Временный инструмент — загрузка фото по ссылке, в обход сломанной штатной загрузки файлов. Можно сразу назначить обложкой записи или просто добавить в медиатеку.
*/

add_action('admin_menu', function() {
    add_menu_page('Загрузка фото по ссылке', 'Фото по ссылке', 'manage_options', 'gigsbot-sideload', 'gigsbot_sideload_page', 'dashicons-upload');
});

function gigsbot_sideload_page() {
    if (!current_user_can('manage_options')) return;

    $message = '';
    if (isset($_POST['gigsbot_sideload_submit']) && check_admin_referer('gigsbot_sideload')) {
        error_log('GIGSBOT SIDELOAD: form submitted');
        $url = trim($_POST['image_url'] ?? '');
        $post_id = (int) ($_POST['post_id'] ?? 0);
        error_log('GIGSBOT SIDELOAD: url=[' . $url . '] post_id=[' . $post_id . ']');

        if ($url) {
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';

            $attachment_id = media_sideload_image($url, $post_id, null, 'id');

            if (is_wp_error($attachment_id)) {
                error_log('GIGSBOT SIDELOAD ERROR CODE: ' . $attachment_id->get_error_code());
                error_log('GIGSBOT SIDELOAD ERROR MESSAGE: ' . $attachment_id->get_error_message());
                error_log('GIGSBOT SIDELOAD ERROR DATA: ' . print_r($attachment_id->get_error_data(), true));
                $message = '<div class="notice notice-error" style="padding:15px;"><p><b>Ошибка:</b> ' . esc_html($attachment_id->get_error_message()) . '</p><p>Код: ' . esc_html($attachment_id->get_error_code()) . '</p></div>';
            } elseif ($post_id) {
                error_log('GIGSBOT SIDELOAD: success, attachment_id=' . $attachment_id);
                set_post_thumbnail($post_id, $attachment_id);
                $edit_link = get_edit_post_link($post_id);
                $title = get_the_title($post_id);
                $message = '<div class="notice notice-success" style="padding:15px;"><p>Готово! Фото прикреплено и назначено обложкой записи «' . esc_html($title) . '». <a href="' . esc_url($edit_link) . '">Открыть запись →</a></p></div>';
            } else {
                error_log('GIGSBOT SIDELOAD: success, attachment_id=' . $attachment_id);
                $media_link = admin_url('upload.php?item=' . $attachment_id);
                $message = '<div class="notice notice-success" style="padding:15px;"><p>Готово! Фото добавлено в медиатеку (без привязки к записи). <a href="' . esc_url($media_link) . '">Открыть в медиатеке →</a></p></div>';
            }
        } else {
            $message = '<div class="notice notice-error" style="padding:15px;"><p>Укажите ссылку на картинку.</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <h1>Загрузка фото по ссылке</h1>
        <p>Временный инструмент, пока на хостинге не починили обычную загрузку файлов. Скачивает картинку по ссылке и либо просто кладёт её в медиатеку, либо сразу назначает обложкой указанной записи.</p>
        <?php echo $message; ?>
        <form method="post">
            <?php wp_nonce_field('gigsbot_sideload'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="image_url">Ссылка на картинку (например, с imgbb.com)</label></th>
                    <td><input type="url" name="image_url" id="image_url" class="regular-text" required placeholder="https://i.ibb.co/xxxxx/photo.jpg"></td>
                </tr>
                <tr>
                    <th><label for="post_id">ID записи (необязательно)</label></th>
                    <td><input type="number" name="post_id" id="post_id" class="regular-text">
                        <p class="description">Если указать ID — фото сразу станет обложкой этой записи.<br>Если оставить пустым — фото просто добавится в медиатеку, без привязки. ID видно в адресной строке при редактировании записи: .../post.php?post=<b>ЧИСЛО</b>&action=edit</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Загрузить', 'primary', 'gigsbot_sideload_submit'); ?>
        </form>
    </div>
    <?php
}

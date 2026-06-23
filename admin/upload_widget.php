<?php
/**
 * Reusable Image Upload Widget Helper
 * 
 * Usage: include this file and call render_image_upload_widget($config)
 * 
 * Config keys:
 *   field_name   - The hidden input name (e.g. 'image')
 *   widget_id    - Unique string to make all element IDs unique (e.g. 'speaker')
 *   current_url  - Current image URL (for edit forms, to show existing image)
 *   label        - Label text (default: 'Image')
 *   optional     - Whether field is optional (default: true)
 */
function render_image_upload_widget($config = []) {
    $field_name  = isset($config['field_name'])  ? $config['field_name']  : 'image';
    $widget_id   = isset($config['widget_id'])   ? $config['widget_id']   : 'img';
    $current_url = isset($config['current_url']) ? $config['current_url'] : '';
    $label       = isset($config['label'])       ? $config['label']       : 'Image';
    $optional    = isset($config['optional'])    ? $config['optional']    : true;

    $drop_id     = 'drop_' . $widget_id;
    $file_id     = 'file_' . $widget_id;
    $hidden_id   = 'hidden_' . $widget_id;
    $preview_id  = 'preview_' . $widget_id;
    $img_id      = 'previmg_' . $widget_id;
    $progress_id = 'prog_' . $widget_id;
    $error_id    = 'err_' . $widget_id;
    $clear_id    = 'clear_' . $widget_id;

    $has_image   = !empty($current_url);
    $preview_vis = $has_image ? 'visible' : '';
    ?>
    <div class="image-upload-widget">
        <label class="form-label">
            <?php echo htmlspecialchars($label); ?>
            <?php if ($optional): ?>
                <span style="font-weight:400; text-transform:none; color:#94a3b8; letter-spacing:0;">(optional)</span>
            <?php endif; ?>
        </label>

        <input type="hidden" id="<?php echo $hidden_id; ?>" name="<?php echo $field_name; ?>" value="<?php echo htmlspecialchars($current_url); ?>">

        <div class="upload-drop-zone" id="<?php echo $drop_id; ?>">
            <input type="file" id="<?php echo $file_id; ?>" accept="image/*">
            <span class="upload-icon">📸</span>
            <div class="upload-text">Click to browse or drag & drop an image</div>
            <div class="upload-subtext">JPG, PNG, WebP, GIF — max 10MB</div>
        </div>

        <div class="upload-progress" id="<?php echo $progress_id; ?>">
            <div class="upload-progress-spinner"></div>
            <span>Uploading to Cloudinary…</span>
        </div>

        <div class="upload-error" id="<?php echo $error_id; ?>"></div>

        <div class="upload-preview <?php echo $preview_vis; ?>" id="<?php echo $preview_id; ?>">
            <img id="<?php echo $img_id; ?>" src="<?php echo htmlspecialchars($current_url); ?>" alt="Preview">
            <button class="upload-clear" id="<?php echo $clear_id; ?>" title="Remove image" type="button">✕</button>
        </div>
    </div>

    <script>
    (function() {
        // Defer until DOM ready
        function init() {
            initImageUploadWidget({
                dropZoneId:    '<?php echo $drop_id; ?>',
                fileInputId:   '<?php echo $file_id; ?>',
                hiddenInputId: '<?php echo $hidden_id; ?>',
                previewId:     '<?php echo $preview_id; ?>',
                previewImgId:  '<?php echo $img_id; ?>',
                progressId:    '<?php echo $progress_id; ?>',
                errorId:       '<?php echo $error_id; ?>',
                clearBtnId:    '<?php echo $clear_id; ?>'
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
    </script>
    <?php
}
?>

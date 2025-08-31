<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th scope="row"><label for="slogan">توضیح گالری</label></th>
            <td>
                <textarea rows="5" name="project[galleryDescription]" id="galleryDescription"
                    class="regular-text"><?php echo $galleryDescription ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="slogan">تصاویر</label></th>
            <td>
                <div class="gallery-management-container">

                    <ul id="gallery-images-list" class="sortable-list">
                        <?php foreach ($image_ids as $image_id):
                    if (empty($image_id)) {
                        continue;
                    }

                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                ?>
                        <li class="image-item" data-id="<?php echo esc_attr($image_id); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" />
                            <a href="#" class="remove-image">حذف</a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <button id="upload-gallery-images" class="button button-primary">
                        افزودن عکس‌ها
                    </button>

                    <input type="hidden" id="gallery_items" name="project[gallery]"
                        value="<?php echo esc_attr($gallery); ?>" />
                </div>
            </td>
        </tr>
    </tbody>
</table>
<tr class="form-field">
    <th scope="row">
        <label for="service_icon">آیکون خدمت</label>
    </th>
    <td>
        <input type="hidden" name="service_icon" id="service_icon" value="<?php echo esc_attr($icon_id); ?>" />
        <div id="service_icon_preview" style="margin: 10px 0;">
            <?php if ($icon_url): ?>
            <img src="<?php echo esc_url($icon_url); ?>" style="max-width: 50px; height: 50px; object-fit: contain;" />
            <?php endif; ?>
        </div>
        <input type="button" class="button button-secondary" id="upload_service_icon"
            value="آپلود آیکون" />
        <input type="button" class="button button-secondary" id="remove_service_icon"
            value="حذف آیکون" style="<?php echo ! $icon_id ? 'display: none;' : ''; ?>" />
        <p class="description">آیکون خدمت را انتخاب کنید</p>
    </td>
</tr>

<tr class="form-field">
    <th scope="row">
        <label for="service_poster">پوستر خدمت</label>
    </th>
    <td>
        <input type="hidden" name="service_poster" id="service_poster" value="<?php echo esc_attr($poster_id); ?>" />
        <div id="service_poster_preview" style="margin: 10px 0;">
            <?php if ($poster_url): ?>
            <img src="<?php echo esc_url($logoImage) ?? ''; ?>" style="max-width: 200px; height: auto;" />
            <?php endif; ?>
        </div>
        <input type="button" class="button button-secondary" id="upload_service_poster"
            value="آپلود پوستر" />
        <input type="button" class="button button-secondary" id="remove_service_poster"
            value="حذف پوستر"
            style="<?php echo ! $poster_id ? 'display: none;' : ''; ?>" />
        <p class="description">پوستر خدمت را انتخاب کنید</p>
    </td>
</tr>
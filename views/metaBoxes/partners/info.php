<table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th scope="row"><label for="slogan">شعار</label></th>
            <td><input name="partners[slogan]" type="text" id="slogan" value="<?php echo $slogan ?>"
                    class="d-ltr regular-text">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="site">رنگ</label></th>
            <!-- <td><input name="partners[site]" type="text" id="site" value="<?php echo $site ?>"
                    class="d-ltr regular-text">
            </td> -->
            <td><input name="partners[color]" type="text" id="color"
                    value="<?php echo esc_html($color); ?>"
                    class="regular-text inputColor">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="site">لینک سایت</label></th>
            <td><input name="partners[site]" type="text" id="site" value="<?php echo $site ?>"
                    class="d-ltr regular-text">
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="phone">شماره تماس</label></th>
            <td><input name="partners[phone]" type="text" id="phone" value="<?php echo $phone ?>"
                    class="d-ltr regular-text">
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="email">ایمیل</label></th>
            <td><input name="partners[email]" type="text" id="email" value="<?php echo $email ?>"
                    class="d-ltr regular-text">
            </td>
        </tr>
    </tbody>
</table>
<?php
    defined('ABSPATH') || exit;
    global $title;

?>
<div class="wrap">
    <h1><?php echo $title ?></h1>

    <form method="post" action="" novalidate="novalidate">
        <?php wp_nonce_field(config('app.key') . '_setting_' . get_current_user_id()); ?>
        <table class="form-table" role="presentation">

            <tbody>
                <tr>
                    <th scope="row"><label for="logo">لوگو</label></th>
                    <td> <input type="hidden" name="setting[logo]" id="logo" value="<?php echo esc_attr($logo); ?>" />
                        <div id="logo_preview" style="margin: 10px 0;">
                            <img src="<?php echo esc_url($logoImage); ?>" style="max-width: 200px; height: auto;" />
                        </div>
                        <input type="button" class="button button-secondary" id="upload_logo" value="انتخاب لوگو" />
                        <p class="description">لوگو سایت را انتخاب کنید</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="address">آدرس</label></th>
                    <td><input name="setting[address]" type="text" id="address" value="<?php echo $address ?>"
                            class="regular-text"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="email">ایمیل</label></th>
                    <td><input name="setting[email]" type="email" id="email" value="<?php echo $email ?>"
                            class="regular-text"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="phone">شماره تماس</label></th>
                    <td><input name="setting[phone]" type="text" id="phone" value="<?php echo $phone ?>"
                            class="regular-text"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="footerText">توضیحات فوتر</label></th>

                    <td>
                        <textarea rows="5" name="setting[footerText]" id="footerText"
                            class="regular-text"><?php echo $footerText ?></textarea>
                    </td>
                </tr>


                <tr>
                    <th scope="row"><label for="footerText">شبکه های اجنماعی</label></th>

                    <td>
                        <style>
                        #link-list li {
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                            gap: 10px;
                        }
                        </style>

                        <div>
                            <ul id="link-list">
                                <?php
                                    $m = 1;
                                foreach ($social as $social): ?>
                                <li>
                                    <select name="setting[social][<?php echo $m ?>][type]">
                                        <?php foreach (config('app.socials', [  ]) as $key => $name): ?>
                                        <option<?php selected($key, $social[ 'type' ])?> value="<?php echo $key ?>">
                                            <?php echo $name ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                    <input name="setting[social][<?php echo $m ?>][link]" type="url"
                                        class="regular-text" value="<?php echo esc_url($social[ 'link' ]) ?>">
                                    <button id="remove-link-item" onclick="this.closest('li').remove()" type="button"
                                        class="button button-error">حذف</button>
                                </li>
                                <?php
                                    $m++;
                                endforeach; ?>

                            </ul>

                            <button type="button" id="add-social-item" data-next-item="<?php echo $m ?>"
                                class="button button-success">افزودن</button>

                        </div>
                    </td>
                </tr>


            </tbody>
        </table>



        <p class="submit">
            <button type="submit" name="act" id="submit" value="settingSubmit" class="button button-primary">ذخیرهٔ
                تغییرات</button>
        </p>
    </form>













</div>
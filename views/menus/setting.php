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
                    <th scope="row"><label for="address">آدرس</label></th>
                    <td><input name="setting[address]" type="text" id="address"
                            value="<?php echo $setting[ 'address' ] ?>" class="regular-text"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="email">ایمیل</label></th>
                    <td><input name="setting[email]" type="email" id="email"
                            value="<?php echo $setting[ 'email' ] ?>" class="regular-text"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="phone">شماره تماس</label></th>
                    <td><input name="setting[phone]" type="text" id="phone" value="<?php echo $setting[ 'phone' ] ?>"
                            class="regular-text"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="footerText">توضیحات فوتر</label></th>

                    <td>
                        <textarea rows="5" name="setting[footerText]" id="footerText"
                            class="regular-text"><?php echo $setting[ 'footerText' ]?></textarea>
                    </td>
                </tr>

            </tbody>
        </table>

    <h2 class="title">شبکه های اجنماعی</h2>

        <table class="form-table" role="presentation">

            <tbody>
                <tr>
                    <th scope="row"><label for="instagram">اینستاگرام</label></th>
                    <td><input name="setting[social][instagram]" type="url" id="instagram"
                            value="<?php echo $setting['social'][ 'instagram' ]?? '' ?>" class="regular-text"></td>
                </tr>

                <tr>
                    <th scope="row"><label for="telegram">تلگرام</label></th>
                    <td><input name="setting[social][telegram]" type="url" id="telegram" value="<?php echo $setting['social'][ 'telegram' ]?? '' ?>"
                            class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="github">گیت هاب</label></th>
                    <td><input name="setting[social][github]" type="url" id="github" value="<?php echo $setting['social'][ 'github' ]?? '' ?>"
                            class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="linkedin">لینکدین</label></th>
                    <td><input name="setting[social][linkedin]" type="url" id="linkedin" value="<?php echo $setting['social'][ 'linkedin' ]?? '' ?>"
                            class="regular-text"></td>
                </tr>



            </tbody>
        </table>


        <p class="submit">
            <button type="submit" name="act" id="submit" value="settingSubmit" class="button button-primary">ذخیرهٔ
                تغییرات</button>
        </p>
    </form>













</div>
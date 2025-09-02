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
        foreach ($links as $link): ?>
        <li>
            <select name="project[links][<?php echo $m?>][type]">
                <?php foreach (config('app.linkList', [  ]) as $key => $name): ?>
                <option<?php selected($key, $link[ 'type' ])?> value="<?php echo $key ?>"><?php echo $name ?></option>
                <?php endforeach; ?>
            </select>
            <input name="project[links][<?php echo $m?>][link]" type="url" class="w-100 regular-text"
                value="<?php echo esc_url($link[ 'link' ]) ?>">
            <button id="remove-link-item" onclick="this.closest('li').remove()" type="button"
                class="button button-error">حذف</button>
        </li>
        <?php
            $m++;
        endforeach; ?>

    </ul>

    <button type="button" id="add-link-item" data-next-item="<?php echo $m ?>"
        class="button button-success">افزودن</button>

</div>
<style>
#service-list li {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

#service-list li img {
    width: 40px;
    height: 40px;
}
</style>

<div>
    <ul id="service-list">

    <?php foreach ($terms as $term): ?>
        <li>
            <img src="<?php echo $term[ 'icon' ]?>" alt="<?php echo $term[ 'title' ]?>">
            <a target="_blank" href="<?php echo admin_url('term.php?taxonomy=services&tag_ID=' . $term[ 'id' ] . '&post_type=partners') ?>"
                class=""><span><?php echo $term[ 'title' ]?></span></a>

        </li>
    <?php endforeach; ?>


    </ul>

    <a target="_blank" href="<?php echo admin_url('edit-tags.php?taxonomy=services&post_type=partners') ?>"
        class="button button-success">افزودن</a>

</div>
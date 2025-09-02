<style>


</style>

<div>
    <p id="isEmpty" class="">محری پروژه رو انتخاب کنید</p>

    <?php foreach ($services as $key => $service): ?>
    <div class="d-none" id="<?php echo $key ?>">

        <h4><?php echo $servicesName[ $key ] ?></h4>
        <fieldset>
            <legend class="screen-reader-text"><?php echo $servicesName[ $key ] ?></legend>

            <?php foreach ($service as $row): ?>
            <div>
                <input type="checkbox" name="project[partner][]" id="partner-id" value="<?php echo $row[ "id" ] ?>">
                <label for="partner-id"><?php echo $row[ "title" ] ?></label>
            </div>
            <?php endforeach; ?>
        </fieldset>

    </div>
    <?php endforeach; ?>
</div>
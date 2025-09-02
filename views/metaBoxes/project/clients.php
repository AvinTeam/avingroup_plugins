<div>
    <fieldset>
        <legend class="screen-reader-text">مشتری</legend>
        <?php foreach ($clients as $client): ?>
        <input type="radio" name="project[client]" id="client-<?php echo $client[ 'id' ] ?>" value="<?php echo $client[ 'id' ] ?>"<?php checked($isCorrect, $client[ 'id' ])?>>
        <label for="client-<?php echo $client[ 'id' ] ?>"><?php echo $client[ 'title' ] ?></label>
        <br>
        <?php endforeach; ?>
    </fieldset>
</div>
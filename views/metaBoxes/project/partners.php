<div>
    <fieldset>
        <legend class="screen-reader-text">مجریان</legend>
        <?php foreach ($partners as $partner): ?>
        <input type="checkbox" name="project[partner][]" id="partner-<?php echo $partner[ 'id' ] ?>" value="<?php echo $partner[ 'id' ] ?>" <?php if(in_array($partner[ 'id' ], $isCorrect)){echo 'checked="checked"';}?>>
        <label for="partner-<?php echo $partner[ 'id' ] ?>"><?php echo $partner[ 'title' ] ?></label>
        <br>
        <?php endforeach; ?>
    </fieldset>
</div>       
 

<div>








    <select id="select2ProjectClients" class="form-select form-select-lg py-3 my-4 w-100" name="state">
        <option></option>
        <?php foreach ($clients as $client): ?>
        <option value="<?php echo $client[ 'id' ] ?>"<?php selected($isCorrect, $client[ 'id' ])?> ><?php echo $client[ 'title' ] ?></option>
        <?php endforeach; ?>
    </select>

</div>
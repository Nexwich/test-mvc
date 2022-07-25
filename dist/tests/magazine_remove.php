<?php
$magazines = file_get_contents(__DIR__ . '/../data/magazines.json');
$magazines = json_decode($magazines, true);

?>

<form action="/magazine/delete" method="post" enctype="multipart/form-data">
  <div>
    <label>
      <select name="_id">
        <?php foreach ($magazines as $magazine) { ?>
          <option value="<?= $magazine['_id'] ?>"><?= $magazine['title'] ?></option>
        <?php } ?>
      </select>
    </label>
  </div>

  <div>
    <button type="submit"></button>
  </div>
</form>

<?php
$magazines = file_get_contents(__DIR__ . '/../data/magazines.json');
$magazines = json_decode($magazines, true);

$authors = file_get_contents(__DIR__ . '/../data/authors.json');
$authors = json_decode($authors, true);

?>

<form action="/magazine/update" method="post" enctype="multipart/form-data">
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
    <label>
      <input type="text" name="title" placeholder="title">
    </label>
  </div>

  <div>
    <label>
      <input type="text" name="caption" placeholder="caption">
    </label>
  </div>

  <div>
    <button type="submit"></button>
  </div>
</form>

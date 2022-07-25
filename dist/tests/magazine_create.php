<?php
$authors = file_get_contents(__DIR__ . '/../data/authors.json');
$authors = json_decode($authors, true);

?>

<form action="/magazine/add" method="post" enctype="multipart/form-data">
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
    <label>
      <input type="file" name="image" placeholder="image">
    </label>
  </div>

  <div>
    <label>
      <select name="authors[]" multiple="multiple">
        <?php foreach ($authors as $author) { ?>
          <option value="<?= $author['_id'] ?>"><?= $author['name'] . ' ' . $author['lastName'] ?></option>
        <?php } ?>
      </select>
    </label>
  </div>

  <div>
    <label>
      <input type="date" name="publishDate" placeholder="publishDate">
    </label>
  </div>

  <div>
    <button type="submit"></button>
  </div>
</form>

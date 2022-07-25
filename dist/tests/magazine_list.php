<?php
$magazines = file_get_contents(__DIR__ . '/../data/magazines.json');
$magazines = json_decode($magazines, true);

?>

<?php foreach ($magazines as $magazine) { ?>
  <div>
    <?= $magazine['title'] ?>

    <img src="<?= $magazine['image'] ?>" alt="">
  </div>
<?php } ?>

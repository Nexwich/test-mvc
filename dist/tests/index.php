<pre>
<?php

// автор
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/author/list');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$out = curl_exec($curl);
echo '<br>Список авторов - ' . $out;
curl_close($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/author/add');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'name=test1name&lastName=test1lastName');
$out = curl_exec($curl);
echo '<br>Добавлен автор - ' . $out;
curl_close($curl);

$author = json_decode($out, true);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/author/update');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, '_id=' . $author['_id'] . '&name=test1name_Rename');
$out = curl_exec($curl);
echo '<br>Изменен автор - ' . $out;
curl_close($curl);

$author = json_decode($out, true);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/author/delete');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, '_id=' . $author['_id']);
$out = curl_exec($curl);
echo '<br>Удален автор - ' . $out;
curl_close($curl);

// журнал
echo '<br><br>';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/magazine/list');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$out = curl_exec($curl);
echo '<br>Список журналов - ' . $out;
curl_close($curl);

$data = [
  'title' => 'test_magazine',
  'caption' => 'test_magazine',
  'image' => 'https://www.php.net/images/php8/logo_php8_1.svg',
  'authors' => [1, 2],
  'publishDate' => date('Y-m-d'),
];
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/magazine/add');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'data=' . json_encode($data));
$out = curl_exec($curl);
echo '<br>Добавлен журнал json строкой - ' . $out;
curl_close($curl);

$magazine = json_decode($out, true);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/magazine/update');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, '_id=' . $magazine['_id'] . '&title=test_magazine_Rename');
$out = curl_exec($curl);
echo '<br>Изменен журнал - ' . $out;
curl_close($curl);

$magazine = json_decode($out, true);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://nexwich.tk/magazine/delete');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, '_id=' . $magazine['_id']);
$out = curl_exec($curl);
echo '<br>Удален журнал - ' . $out;
curl_close($curl);

?>
</pre>

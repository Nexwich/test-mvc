<?php

namespace system\models;

use system\classes\model;
use system\fields\datetime;
use system\fields\multiselect;
use system\fields\text;

class magazine extends model {
  public string $store = '/magazines.json';
  protected array $fields = [
    [
      'name' => 'title',
      'title' => 'Название',
      'class' => text::class,
      'require' => true,
    ],
    [
      'name' => 'caption',
      'title' => 'Короткое описание',
      'class' => text::class,
      'require' => false,
    ],
    [
      'name' => 'image',
      'title' => 'Картинка',
      'class' => text::class,
      'require' => false,
      'path' => '/files/magazines/',
    ],
    [
      'name' => 'authors',
      'title' => 'Авторы',
      'class' => multiselect::class,
      'require' => true,
    ],
    [
      'name' => 'publishDate',
      'title' => 'Дата выпуска журнала',
      'class' => datetime::class,
      'require' => true,
    ],
  ];
}

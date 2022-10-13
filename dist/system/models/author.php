<?php

namespace system\models;

use system\classes\model;
use system\fields\text;

class author extends model {
  public string $store = '/authors.json';
  protected array $fields = [
    [
      'module' => 'author',
      'name' => 'name',
      'title' => 'Имя',
      'class' => text::class,
      'require' => true,
      'minLength' => 3,
    ],
    [
      'module' => 'author',
      'name' => 'lastName',
      'title' => 'Фамилия',
      'class' => text::class,
      'require' => true,
    ],
    [
      'module' => 'author',
      'name' => 'patronymic',
      'title' => 'Отчество',
      'class' => text::class,
      'require' => false,
    ],
  ];
}

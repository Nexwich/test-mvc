<?php

namespace model;

class author extends model {
  public $store = 'authors.json';
  protected $fields = [
    [
      "module" => "author",
      "name" => "name",
      "title" => "Имя",
      "type" => "cm_string",
      "require" => true,
      "minLength" => 3
    ],
    [
      "module" => "author",
      "name" => "lastName",
      "title" => "Фамилия",
      "type" => "cm_string",
      "require" => true
    ],
    [
      "module" => "author",
      "name" => "patronymic",
      "title" => "Отчество",
      "type" => "cm_string",
      "require" => false
    ],
  ];
}

<?php

namespace model;

class magazine extends model {
  public $store = 'magazines.json';
  protected $fields = [
    [
      "name" => "title",
      "title" => "Название",
      "type" => "cm_string",
      "require" => true
    ],
    [
      "name" => "caption",
      "title" => "Короткое описание",
      "type" => "cm_string",
      "require" => false
    ],
    [
      "name" => "image",
      "title" => "Картинка",
      "type" => "cm_file",
      "require" => false,
      "path" => "/files/magazines/"
    ],
    [
      "name" => "authors",
      "title" => "Авторы",
      "type" => "cm_multiselect",
      "require" => true
    ],
    [
      "name" => "publishDate",
      "title" => "Дата выпуска журнала",
      "type" => "cm_datetime",
      "require" => true
    ]
  ];
}

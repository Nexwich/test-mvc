<?php

namespace model;

abstract class model {
  protected $id = '_id'; // Название поля для идентификатора в хранилище
  protected $fields = []; // Поля

  protected $store;
  protected $store_path;
  protected $items = [];
  protected $data = [];

  public function __construct () {
    $this->store_path = realpath(__DIR__ . '/../../data') . '/' . $this->store;
  }

  /**
   * Получить список полей
   * @return array
   */
  public function get_fields () {
    return $this->fields;
  }

  /**
   * Получить id выбранного объекта
   * @return string|int
   */
  public function get_id () {
    if (!empty($this->data[$this->id])) return $this->data[$this->id];
    return false;
  }

  /**
   * Получить данные объекта
   * @return array
   */
  public function get_data () {
    return $this->data;
  }

  /**
   * Получить список объектов
   * @return array
   */
  public function get_items () {
    if (!$this->items and $this->store) {
      $items = file_get_contents($this->store_path);
      $this->items = json_decode($items, true);
    }

    return ($this->items ?: []);
  }

  /**
   * Получить значение поля
   * @param string $name Название поля
   * @return mixed
   */
  public function get ($name) {
    return (!empty($this->data[$name]) ? $this->data[$name] : null);
  }

  /**
   * Изменить значение поля
   * @param string $name Название поля
   * @param string $value Значение поля
   * @return $this
   */
  public function set_value ($name, $value) {
    $this->data[$name] = $value;
    return $this;
  }

  /**
   * Изменить значения полей
   * @param array $values Массив значений для установки
   * @return $this
   */
  public function set_values ($values) {
    foreach ($values as $name => $value) {
      $this->set_value($name, $value);
    }

    return $this;
  }

  /**
   * Заменить значения
   * @param array $data Входное данные
   * @return $this
   */
  protected function set_data ($data) {
    $this->data = $data;
    return $this;
  }

  /**
   * Выбрать объект
   * @param array $id Id объекта
   * @return $this
   */
  public function load_by_id ($id) {
    $items = $this->get_items();

    foreach ($items as $item) {
      if ($item[$this->id] == $id) {
        $this->set_data($item);
      }
    }

    if (!$this->get_id()) {
      var_dump('Нет объекта');
      exit();
    }

    return $this;
  }

  /**
   * Создать объект
   * @return $this
   */
  public function insert () {
    $items = $this->get_items();
    $this->set_value($this->id, md5(microtime()));
    $save_data = $items;
    array_push($save_data, $this->data);

    $this->record($save_data);

    return $this;
  }

  /**
   * Обновить объект
   * @return $this
   */
  public function update () {
    $items = $this->get_items();
    $save_data = [];

    foreach ($items as $item) {
      if ($item[$this->id] == $this->get_id()) {
        $save_data[] = $this->data;
      }else {
        $save_data[] = $item;
      }
    }

    $this->record($save_data);

    return $this;
  }

  /**
   * Сохранить объект
   * @return $this
   */
  public function save () {
    if (!empty($this->get_id())) {
      $this->update();
    }else {
      $this->insert();
    }

    return $this;
  }

  /**
   * Удалить выбранные объект
   * @return $this
   */
  public function remove () {
    $items = $this->get_items();
    $save_data = [];
    $id = $this->get_id();

    foreach ($items as $item) {
      if ($item[$this->id] == $id) {
        $this->set_data($item);
        $this->clear();
      }else {
        $save_data[] = $item;
      }
    }

    $this->record($save_data);

    return $this;
  }

  /**
   * Записать объект в хранилище
   * @param array $data Входное значение
   * @return $this
   */
  protected function record ($data) {
    if (file_exists($this->store_path)) {
      file_put_contents($this->store_path, json_encode($data));
    }

    return $this;
  }

  /**
   * Обработать объект по полям
   * @param array $data Входное данные
   * @return $this
   */
  public function prepare ($data) {
    foreach ($this->fields as $model_field) {
      $value = isset($data[$model_field['name']]) ? $data[$model_field['name']] : null;
      $current_value = $this->get($model_field['name']);

      if (!$value and $model_field['require'] and !$current_value) {
        var_dump('Поле «' . $model_field['title'] . '» обязательно к заполнению');
        exit;
      }

      if ($value === null and $current_value) {
        $this->set_value($model_field['name'], $current_value);
        continue;
      };

      $field_class_name = '\field\\' . $model_field['type'];
      $field = new $field_class_name($model_field);
      $is = $field->prepare($value);

      if (!$is and $model_field['require']) {
        var_dump('Поле «' . $model_field['title'] . '» неверно заполнено');
        exit;
      }

      $this->set_value($field->get_name(), $field->get_value());
    }

    return $this;
  }

  protected function clear () {
    $data = $this->get_data();

    foreach ($this->fields as $model_field) {
      $field_class_name = '\field\\' . $model_field['type'];
      $field = new $field_class_name($model_field);
      $field->clear($data[$model_field['name']]);
    }
  }
}

<?php

namespace system\classes;

/**
 * Модель
 */
abstract class model {
  protected string $id = '_id'; // Название поля для идентификатора в хранилище
  protected array $fields = []; // Поля
  protected string $store;
  protected string $store_path;
  protected array $items = [];
  protected array $data = [];

  public function __construct () {
    $this->store_path = realpath(__DIR__ . '/../../') . '/data' . $this->store;
  }

  /**
   * Получить список полей
   * @return array
   */
  public function get_fields (): array {
    return $this->fields;
  }

  /**
   * Изменить значения полей
   * @param array $values Массив значений для установки
   * @return $this
   */
  public function set_values (array $values): model {
    foreach ($values as $name => $value) {
      $this->set_value($name, $value);
    }

    return $this;
  }

  /**
   * Изменить значение поля
   * @param string $name Название поля
   * @param $value Значение поля
   * @return $this
   */
  public function set_value (string $name, $value): model {
    $this->data[$name] = $value;
    return $this;
  }

  /**
   * Выбрать объект
   * @param $id Id объекта
   * @return $this
   */
  public function load_by_id ($id): model {
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
   * Получить список объектов
   * @return array
   */
  public function get_items (): array {
    if (!$this->items and $this->store) {
      $items = file_get_contents($this->store_path);
      $this->items = json_decode($items, true);
    }

    return ($this->items ?: []);
  }

  /**
   * Получить id выбранного объекта
   * @return string|int|bool
   */
  public function get_id () {
    if (!empty($this->data[$this->id])) return $this->data[$this->id];
    return false;
  }

  /**
   * Сохранить объект
   * @return $this
   */
  public function save (): model {
    if (!empty($this->get_id())) {
      $this->update();
    }else {
      $this->insert();
    }

    return $this;
  }

  /**
   * Обновить объект
   * @return $this
   */
  public function update (): model {
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
   * Записать объект в хранилище
   * @param array $data Входное значение
   * @return $this
   */
  protected function record (array $data): model {
    if (file_exists($this->store_path)) {
      file_put_contents($this->store_path, json_encode($data));
    }

    return $this;
  }

  /**
   * Создать объект
   * @return $this
   */
  public function insert (): model {
    $items = $this->get_items();
    $save_data = $items;

    $this->set_value($this->id, md5(microtime()));
    array_push($save_data, $this->data);
    $this->record($save_data);
    return $this;
  }

  /**
   * Удалить выбранные объект
   * @return $this
   */
  public function remove (): model {
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

  protected function clear () {
    $data = $this->get_data();

    foreach ($this->fields as $model_field) {
      $field = new $model_field['class']($model_field);
      $field->clear($data[$model_field['name']]);
    }
  }

  /**
   * Получить данные объекта
   * @return array
   */
  public function get_data (): array {
    return $this->data;
  }

  /**
   * Заменить значения
   * @param array $data Входное данные
   * @return $this
   */
  protected function set_data (array $data): model {
    $this->data = $data;
    return $this;
  }

  /**
   * Обработать объект по полям
   * @param array $data Входное данные
   * @return $this
   */
  public function prepare (array $data): model {
    foreach ($this->fields as $model_field) {
      $value = $data[$model_field['name']] ?? null;
      $current_value = $this->get($model_field['name']);

      if (!$value and $model_field['require'] and !$current_value) {
        die('Поле «' . $model_field['title'] . '» обязательно к заполнению');
      }

      if ($value === null and $current_value) {
        $this->set_value($model_field['name'], $current_value);
        continue;
      };

      $field = new $model_field['class']($model_field);
      $is = $field->prepare($value);

      if (!$is and $model_field['require']) {
        die('Поле «' . $model_field['title'] . '» неверно заполнено');
      }

      $this->set_value($field->get_name(), $field->get_value());
    }

    return $this;
  }

  /**
   * Задать значение
   * @param string $name ключ в массиве $this->data
   * @param mixed $value новое значение
   * @return self
   */
  public function set($name, $value) {
    $this->data[$name] = $value;

    return $this;
  }

  /**
   * Получить значение
   * @param string $name ключ в массиве $this->data
   * @return mixed значение
   */
  public function get($name) {
    return $this->data[$name] ?? NULL;
  }

  /**
   * Проверка наличия свойства
   * @param string $name
   * @return boolean
   */
  public function has_property($name) {
    return array_key_exists($name, $this->data);
  }

  // ArrayAccess
  public function offsetGet($offset) {
    return $this->get($offset);
  }

  public function offsetSet($offset, $value) {
    $this->set($offset, $value);
  }

  public function offsetExists($offset) {
    return $this->has_property($offset);
  }

  public function offsetUnset($offset) {
    unset($this->data[$offset]);
  }

  // Iterator
  public function rewind() {
    reset($this->data);
  }

  public function current() {
    return $this->offsetGet(key($this->data));
  }

  public function key() {
    return key($this->data);
  }

  public function next() {
    return next($this->data);
  }

  public function valid() {
    return (key($this->data) !== null);
  }
}

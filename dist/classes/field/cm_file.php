<?php

namespace field;

class cm_file extends field {
  public function prepare ($value) {
    $this->value = $this->file_upload($value);
    return $this->value;
  }

  /**
   * Сохранить файл
   * @return string Путь к файлу
   */
  protected function file_upload ($value) {
    if (!empty($_FILES[$this->name]['name'])) {
      $path_parts = pathinfo($_FILES[$this->name]['name']);
      $file_name = md5(microtime() . $_FILES[$this->name]['name']) . '.' . $path_parts['extension'];
      $file_save_root = __DIR__ . '/../../files/' . $file_name;

      if (!move_uploaded_file($_FILES[$this->name]['tmp_name'], $file_save_root)) {
        var_dump('Ошибка загрузки файла');
        exit();
      }

      return '/files/' . $file_name;
    }elseif (!empty($value)) {
      $file = file_get_contents($value);

      $path_parts = pathinfo($value);
      $file_name = md5(microtime() . $value) . '.' . $path_parts['extension'];
      $file_save_root = __DIR__ . '/../../files/' . $file_name;

      file_put_contents($file_save_root, $file);

      return '/files/' . $file_name;
    }

    return false;
  }

  public function clear ($data) {
    $file_root = __DIR__ . '/../../' . $data;
    if (file_exists($file_root)) unlink($file_root);
  }
}

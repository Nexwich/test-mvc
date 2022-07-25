<?php

namespace controller;

abstract class controller {
  protected $model_name = '\model\model';
  protected $view_name = '\view\view';

  protected $model;
  protected $view;

  public function __construct () {
    $this->model = new $this->model_name();
    $this->view = new $this->view_name();
  }

  /**
   * Выбрать действие
   * @param string $action_name Название действия
   */
  public function execute ($action_name) {
    $action_name = 'action_' . $action_name;
    $this->$action_name();
  }

  /**
   * Получить объекты
   * @return array
   */
  protected function get_items () {
    $src_data = $this->model->get_items();
    $data = $src_data;

    if (!empty($_GET['page'])) {
      $data = [];

      $per_page = !empty($_GET['perPage']) ? $_GET['perPage'] : 2;
      $finish = $_GET['page'] * $per_page;
      $count = count($src_data);
      $start = $finish - $per_page;
      $finish = $finish <= $count ? $finish : $count;

      for ($i = $start; $i < $finish; $i += 1) {
        $data[] = $src_data[$i];
      }
    }

    return $data;
  }
}

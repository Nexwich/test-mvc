<?php

namespace system\controllers;

use system\classes\controller;
use system\traits\default_actions;
use system\views\template;

/**
 * Автор
 */
class author extends controller {
  public $model_class = \system\models\author::class;
  public $view_class = template::class;
  use default_actions;
}

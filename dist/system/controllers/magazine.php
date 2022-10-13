<?php

namespace system\controllers;

use system\classes\controller;
use system\traits\default_actions;
use system\views\template;

/**
 * Журнал
 */
class magazine extends controller {
  public $model_class = \system\models\magazine::class;
  public $view_class = template::class;
  use default_actions;
}

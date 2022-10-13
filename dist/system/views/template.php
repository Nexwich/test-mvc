<?php

namespace system\views;

use system\classes\view;

/**
 * Вывод шаблонами
 */
class template extends view {
  /**
   * Выводит шаблон
   * @param $template_view
   * @param array $data
   */
  function generate ($template_view, $data = []) {
    if (is_array($data)) {
      extract($data);
    }

    require realpath(__DIR__ . '/../../') . '/templates/' . $template_view;
  }
}

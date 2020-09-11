<?php
namespace App\Core;
/**
 * Class Response
 * @package App\Core
 */
class Response
{
    /**
     * @param $view
     * @param $layout
     * @param $data
     * @return false|string
     */
    function renderView($view, $layout, $data = [])
    {
        extract($data);
        ob_start();
        require __DIR__ . "/../../views/$view.view.php";
        $mainContent = ob_get_clean();
        ob_start();
        require __DIR__ . "/../../views/layouts/$layout.php";
        return ob_get_clean();
    }
}
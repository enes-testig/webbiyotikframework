<?php

namespace Framework\Core;

use Framework\Layouts\Core\View as IView;
use Framework\Helpers\CDN;

/**
 * Webbiyotik view class
 *
 * 
 * @package Webbiyotik
 * @license MIT
 * @copyright 2018
 */
class View implements IView
{
    /**
     * Render view file.
     *
     * @param  string $path
     * @param  array  $data
     * @return void
     */
    public static function render(String $path, $data = [])
    {
        $twig = Registry::get('Twig');

        /* Check theme path for import theme functions */
        if (is_admin_folder()) {
            $viewDir = ADMIN_VIEW;
        } else {
            $viewDir = THEME_DIR;
        }

        /* Check theme functions.php and import */
        if (file_exists($viewDir.'functions.php')) {
            require $viewDir.'functions.php';
        }

        /* Default data */
        $data['CDNStyles']  = CDN::styles();
        $data['CDNScripts'] = CDN::scripts();
        $data['CDNFontAwesomeList'] = CDN::fontAwesomeList();

        /* Render */
        if (file_exists($viewDir."template/$path.twig")) {
            echo $twig->render("template/$path.twig", $data);
        } elseif(file_exists($viewDir."template/static/$path.twig")) {
            echo $twig->render("template/static/$path.twig", $data);
        } else {
            $msg = "$path.twig file is not found!";

            /* Add error log and exit */
            Logger::addErrorLog(E_WARNING, $msg, "", 0);
            exit($msg);
        }
    }
}

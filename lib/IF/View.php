<?php
/**
 * Clase IF_View
 * Clase que realiza la gestión de la vista.
 *
 * @category Ichi Framework
 * @package IF_${FILE_NAME}
 * @author Sergio Brocos [sergio at gmail dot com]
 * @version
 * @since
 * @licence http://ichiframework.es/descargas/licencia
 * Date: 03/02/13
 * Time: 13:03
 */

namespace ICHI;
class IF_View
{
    protected $_pathViews;
    private static $instance;

    /**
     * Is Construct empty?? because used Singleton Pattern
     */
    private function __construc()
    {

    }

    /**
     * Function get a Instance is not exist previouly.
     * Implementation of Singleton Pattern.
     * @return __CLASS__
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new __CLASS__;
        }

        return self::$instance;
    }
}
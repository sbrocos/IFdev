<?php
/**
 * Clase IF_REQUEST
 * Clase que realiza la gestión del REQUEST.
 * Procesa la URI para que IF_APPLICATION gestione el MVC.
 * Procesa _GET y el _POST
 *
 * @category Ichi Framework
 * @package IF_Request
 * @author Sergio Brocos Gómez [sergiobrocos at gmail dot com]
 * @copyright 2012
 * @version V.0.2
 * @since Class available since Release V.0.1

 * @licence http://ichiframework.es/descargas/licencia
 */
namespace ICHI;

class IF_Request
{
    protected $_request;
    protected $_uri;

    /**
     * Función del constructor de la clase.
     * une en una variable el POST y el GET.
     */
    public function __construct()
    {
        $this->_request = array_merge_recursive($_GET, $_POST);
        $this->_setUri();
    }

    /**
     *
     */
    public function getUri()
    {
        return $this->_uri;
    }

    private function _setUri()
    {
        $query = parse_url($_SERVER['REQUEST_URI']);
        $aux = explode('/', $query['path']);
        unset($aux[0]);
        $this->_uri = $aux;
    }

}

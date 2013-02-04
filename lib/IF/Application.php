<?php
/**
 * Clase IF_APPLICATION
 * Clase que realiza la gestión bruta del CORE del Framework.
 * Se encargará de carga de toda la librería IF, de la carga de la configuración desde el json, y ejecutará las rutinas
 * básicas para que funcione el patrón MVC de la aplicación.
 *
 * @category Ichi Framework
 * @package IF_Application
 * @author Sergio Brocos Gómez [sergiobrocos at gmail dot com]
 * @copyright 2012
 * @version V.0.2
 * @since Class available since Release V.0.1

 * @licence http://ichiframework.es/descargas/licencia
 */
namespace ICHI;

class IF_Application
{
    /**
     * @var IF_Config
     */
    protected $_config;
    /**
     * @var IF_Request
     */
    protected $_request;
    /**
     * @var array;
     */
    protected $_estrucMVC;
    /**
     * Funcion constructora de la clase IF_Application.
     * Inicializa atributos de la clase.
     */
    public function __construct()
    {
        $this->_loadLibrary();
        $this->_config = new IF_Config();
        $this->_isDevelopment();
        $this->_request = new IF_Request();
    }
    /**
     * Function to load a IF library IF.
     * Carga los archivos php de la carpeta principal, el resto los ignora.
     * Revisar?
     */
    private function _loadLibrary()
    {
        $path = realpath(dirname(__FILE__));

        //Accedemos a la ruta de la Liberia para leer los archivos de IF
        $dir_library = @opendir($path) or die("error");
        //Include de la libreria IF, solo archivos php, el resto los ignora
        while ($file = readdir($dir_library)) {
            if (strpos( $file, "php")) {
                include_once $path.'/'.$file;
                //todo revisar que archivos carga en cada momento
            }
        }
        closedir($dir_library);
    }
    /**
     * Función que activa en modo de errores E_STRICT si está configurado como 'development' la configuración de la app
     */
    private function _isDevelopment()
    {
        /** @todo Esta funcionalidad no es correcta ya que sólo se activa dentro de la clase? */
        if ( $this->_config->isDevelopment()) {
            error_reporting(E_ALL| E_STRICT);
            ini_set('display_errors', '1');
        }
    }

    /**
     * Función determina si existe un modulo que coicide con el nombre suministrado en el parámetro,
     * sino le asigna el valor "main"
     * @params
     */
    private function _getModule ($moduleName = null)
    {
        $return = $this->_config->getModuleNameDefault();
        $dir_library = @opendir(APP_PATH) or die("error");

        while ($file = readdir($dir_library)) {
            if ($file === $moduleName) {
                return  true;
            }
        }
        return false;
    }

    public function run()
    {
        $this->_setMVC();

        var_dump($this->_estrucMVC);
    }

    /**
     *
     * Function set the Module Controller Action structure
     */
    private function _setMVC()
    {
        //default values
        $this->_estrucMVC['module'] = $this->_config->getModuleNameDefault();
        $this->_estrucMVC['controller'] = 'Index';
        $this->_estrucMVC['action'] = 'Index';
        //set init values
        $uri = $this->_request->getUri();
        $modular = $this->_config->useModuleStructure();
        //set module value
        if ($modular) {
            if (isset($uri[1])) {
                $this->_estrucMVC['module'] = $this->_existModule($uri[1]);
            }
            if (isset($uri[2])) {
                $this->_estrucMVC['controller'] = $uri[2];
            }
            if (isset($uri[3])) {
                $this->_estrucMVC['action'] = $uri[3];
            }
        } else {
            {
                if (isset($uri[1])) {
                    $this->_estrucMVC['controller'] = $this->_existModule($uri[1]);
                    $this->_estrucMVC['controller'] = $uri[1];
                }
                if (isset($uri[2])) {
                    $this->_estrucMVC['action'] = $uri[2];
                }
            }
        }
    }

    /**
     * Function determine exist a module.
     * The name of module must exist as folder name in app,
     * if not exist this folder, return the name of module by default.
     *
     * @param string $module
     * @return string
     */
    private function _existModule($module)
    {
        $dir_library = @opendir(APP_PATH) or die("error");

        while ($file = readdir($dir_library)) {
            if ( $file === $module) {
                return $module;
            }
        }

        closedir($dir_library);
        return $this->_config->getModuleNameDefault();
    }
}
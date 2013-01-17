<?php
/**
 * Clase IF_Config
 * Clase que realiza la gestión de la configuración.
 * Carga el fichero de configuración básica de la aplicación y proporciona la herramientas para tratar con los datos
 * de configuración obtenidos.
 *
 * @category Ichi Framework
 * @package IF_Config
 * @author Sergio Brocos Gómez [sergiobrocos at gmail dot com]
 * @copyright 2012
 * @version V.0.2
 * @since Class available since Release V.0.1
 * @licence http://ichiframework.es/descargas/licencia
 */
namespace ICHI;

class IF_Config
{
    protected $_json;
    protected $_appConfig;
    public function __construct()
    {
        $this->_readConfigFile();
    }

    /**
     * Función que lee el fichero de configuración y lo guarda en el parámetro _json.
     */
    private function _readConfigFile()
    {
        if (file_exists( APP_PATH.'/config')) {
            $file = file_get_contents( APP_PATH.'/config'.'/config.base.json' );
            $this->_json = json_decode( $file );
            if ($this->_json->application_configure) {
                $this->_appConfig = $this->_json->application_configure;
            } else {
                //TODO show error
                $message = utf8_decode('Error: configuración incorrecta. No se ha encontrado la sección perteneciente a
                "application_configure');
                die($message);
            }
        } else {
            //TODO show error
            $message = utf8_decode('Error: fichero de configuración no encontrado');
            die($message);
        }
    }

    /**
     * Función que determina si la app está en modo development o no.
     */
    public function isDevelopment()
    {
        $return = false;

        if ($this->_appConfig->environment) {
            if (($this->_appConfig->environment == 'development') || ($this->_appConfig->environment = 'desarrollo')) {
                $return = true;
            }
        }
        return $return;
    }

    /**
     * Function determine if the app use the modul structure
     * @return boolean
     */
    public function useModuleStructure()
    {
        $return = false;

        if ($this->_appConfig->use_modul_structure) {
            $useModul = $this->_appConfig->use_modul_structure;
            if (($useModul === 'yes') || ($useModul === 'y') || ($useModul === 'si') || ($useModul === 's')) {
                $return = true;
            }
        }

        return $return;
    }
    /**
     * Función que devuelve el módulo por defecto especificado en el config
     */
    public function getModuleNameDefault()
    {
        $return = 'main';

        if ($this->_appConfig->moduleDefault) {
            $return = $this->_appConfig->moduleDefault;
        }

        return $return;
    }
}

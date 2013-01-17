<?php
namespace MODELOS;

use ICHI\IF_DBCONECTION;
use IF_DEBUG;

class Article extends IF_DBCONECTION
{
//     public $_name;

    public function __construct()
    {
        $this->_name = "article";
        $this->connect();
    }

    public function listArticles()
    {
        $insert = $this->insert();
        $insert->values(array('title'=>'Contacto', 'mini_description' => 'lo que toque'));
\IF_DEBUG::dump($insert->getCode());
        $select = $this->select();

        $list = $this->run($insert);

        return $list;
    }



}
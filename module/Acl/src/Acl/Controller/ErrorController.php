<?php

/**
 * Classe referente controle de permissão de acesso
 *
 * @author    Jerfeson Guerreiro
 * @category  Controller
 * @package   Acl/Controller
 * @copyright 2014  Code Is Sistemas
 * @version   1.0.0
 */
namespace Acl\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ErrorController extends AbstractActionController
{

    /**
     * Renderizar pagina de erro de permissão
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function permissaoAction()
    {
        $this->getResponse()->setStatusCode(302);
        return new ViewModel();
    }
}

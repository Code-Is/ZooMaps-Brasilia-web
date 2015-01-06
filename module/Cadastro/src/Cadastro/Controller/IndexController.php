<?php

namespace Cadastro\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    /**
     * Index
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $view = new ViewModel(array());
        $view->setTerminal($this->getRequest()->isXmlHttpRequest());

        return $view;
    }
}

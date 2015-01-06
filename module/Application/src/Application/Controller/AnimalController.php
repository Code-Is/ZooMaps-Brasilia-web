<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\View\Model\ViewModel;

class AnimalController extends AbstractActionController
{
    public function indexAction()
    {
        $id = $this->params('id', null);
        
        $em = $this->getServiceLocator()->get('EntityManager');
        $repo = $em->getRepository('Cadastro\Entity\Animal');
        $animal = $repo->find($id);
        
        $view = new ViewModel();
        $view->setVariable("animal", $animal);
        $view->setTerminal($this->getRequest()->isXmlHttpRequest());
        return $view;
    }
}
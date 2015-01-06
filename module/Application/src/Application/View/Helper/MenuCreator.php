<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class MenuCreator extends AbstractHelper
{

    /**
     * 
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    private $sm;

    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     */
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $sm)
    {
        $this->sm = $sm->getServiceLocator();
    }
    
    
    public function __invoke($user = null)
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        // Se o usuário não estiver logado, retorna nada
        if($user && $auth->getIdentity()) {
            return $this->renderHtmlUser();
        }
        
        return $this->renderHtml();
    }

    public function gerarMenu()
    {
        
        $match = $this->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch();
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        // Se o usuário não estiver logado, retorna nada
        if(! $auth->getIdentity()) {
            return array();
        }
        
        /* @var $user \Autenticacao\Entity\Usuario */
        $user = $auth->getIdentity();
        
        $resources = array();
        
        foreach ($user->getPerfil()->getFuncaoAcao() as $funcaoAcao) {
            
            $menu = $funcaoAcao->getFuncao()->getMenu();
            $desc = $funcaoAcao->getFuncao()->getDescricao();
            $url = $funcaoAcao->getFuncao()->getUrl();
            $nome = $funcaoAcao->getFuncao()->getNome();
            
            $new = array('controller' => $nome, 'url' => $url, 'desc' => $desc);
            
            if(! isset($resources[$menu]) || ! in_array($new, $resources[$menu])) {
                $resources[$menu][] = $new;
            }
            
        }
        
        return $resources;
    }
    
    public function renderHtml()
    {
        $funcoes = $this->gerarMenu();
        
        $html = '';
        
        foreach($funcoes as $menu => $funcao) {
        	
        	if($menu == '') {
        		continue;
        	}
            
            $html .= '<li class="sub-menu"><a href="#"><span>' . $menu . '<span></a>';
        	$html .= '<ul class="sub">';
        	
        	foreach ($funcao as $acao) {
                $html .= '<li><a href="' . $acao['url'] . '">' . $acao['desc'] . '</a></li>';
        	}
        	
        	$html .= '</ul>';
    		$html .= '</li>'; 
		
        }

        return $html;
    }
    
    public function renderHtmlUser()
    {
        $html = '';
		$html .= '<li class="dropdown">';
		$html .= '<a data-toggle="dropdown" class="dropdown-toggle" href="#">';
		$html .= '<i class="fa fa-user"></i> <span class="username">' . $this->getUser()->getNome() . '</span> <b class="caret"></b>';
		$html .= '</a>';
		$html .= '<ul class="dropdown-menu extended logout">';
		$html .= '<li><a href="' . $this->getView()->url('login/logout') . '"><i class="fa fa-key"></i> Sair</a></li>';
		$html .= '</ul>';
		$html .= '</li>';

        return $html;
    }

    /**
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->sm;
    }

    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sm
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $sm)
    {
        $this->sm = $sm;
    }
    
    public function getUser()
    {
        $autuService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        return $autuService->getIdentity();
    }
}



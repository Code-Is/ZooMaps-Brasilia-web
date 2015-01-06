<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Controller\Plugin\FlashMessenger as PluginFlashMessenger;

/**
 * Mescla mensagens da requisição corrente com as dar equisição anterior
 * e as retorna formatadas.
 *
 *
 * @author Jerfeson Guerreiro
 * @category Helper
 * @version 1.0.0
 * @package Cadastro\View\Helper
 * @todo Mover atributos para arquivos de configuração e criar factory deste helper.
 *      
 */
class DisplayMessage extends AbstractHelper
{

    /**
     * Default attributes for the open format tag
     *
     * @var array
     */
    protected $classMessages = array(
        PluginFlashMessenger::NAMESPACE_INFO => 'alert alert-block alert-info fade in',
        PluginFlashMessenger::NAMESPACE_ERROR => 'alert alert-block alert-danger fade in',
        PluginFlashMessenger::NAMESPACE_SUCCESS => 'alert alert-block alert-success fade in',
        PluginFlashMessenger::NAMESPACE_DEFAULT => 'alert alert-block alert-warning fade in'
    );

    /**
     * Titles of each namespace messenges
     *
     * @var array
     */
    protected $namespaceTitles = array(
        PluginFlashMessenger::NAMESPACE_INFO => '<i class="fa fa-info-circle"></i> Info',
        PluginFlashMessenger::NAMESPACE_ERROR => '<i class="fa fa-frown-o"></i> Erro',
        PluginFlashMessenger::NAMESPACE_SUCCESS => '<i class="fa fa-smile-o"></i> Successo',
        PluginFlashMessenger::NAMESPACE_DEFAULT => '<i class="fa fa-meh-o"></i> Atenção'
    );

    /**
     * Namespaces para adicionar mensagens da requisição corrente como se fosse de requisições
     * anteriores.
     * 
     * @var array
     */
    private static $namespacesToMerge = array(
        PluginFlashMessenger::NAMESPACE_DEFAULT,
        PluginFlashMessenger::NAMESPACE_ERROR,
        PluginFlashMessenger::NAMESPACE_INFO,
        PluginFlashMessenger::NAMESPACE_SUCCESS,
        PluginFlashMessenger::NAMESPACE_WARNING
    );

    /**
     *
     * @var string
     */
    protected $messageOpenFormat = '
            <div %s>
            	<button type="button" class="close" data-dismiss="alert"></button>
            	<h4 class="alert-heading">
            		${TITULO}
            	</h4>
            	<ul>
            		<li>
    ';

    /**
     *
     * @var string
     */
    protected $messageCloseString = '</ul></div>';

    /**
     *
     * @var P21Messenger
     */
    private $render;

    /**
     */
    public function __invoke(array $namespacesToMerge = array(PluginFlashMessenger::NAMESPACE_ERROR))
    {
        $namespaces = array_keys($this->classMessages);
        
        $render = $this->getRender()->getPluginFlashMessenger();
        $refl = new \ReflectionClass($render);
        
        // Merge mensagens correntes
        if ($namespacesToMerge && is_array($namespacesToMerge)) {
            foreach ($namespacesToMerge as $namespaceToMerge) {
                $this->mergeMessagesFromNamespace($namespaceToMerge);
            }
        }
        
        // Geração do html
        $markup = '';
        foreach ($namespaces as $namespace) {
            $classes = $this->classMessages[$namespace];
            $markup .= $this->render($namespace, array(
                $classes
            ));
        }
        
        return $markup;
    }

    /**
     *
     * @return string
     */
    public function render($namespace = PluginFlashMessenger::NAMESPACE_DEFAULT, array $classes = array())
    {
        $markup = $this->getRender()->render($namespace, $classes);
        $title = $this->getTitle($namespace);
        return str_replace('${TITULO}', $title, $markup);
    }

    protected function getRender()
    {
        if (! $this->render) {
            $this->render = $this->getView()->flashmessenger();
            $this->render->setMessageCloseString($this->messageCloseString);
            $this->render->setMessageOpenFormat($this->messageOpenFormat);
        }
        return $this->render;
    }

    /**
     *
     * @param string $namespace            
     * @throws \DomainException
     * @return string
     */
    private function getTitle($namespace = PluginFlashMessenger::NAMESPACE_DEFAULT)
    {
        if (isset($this->namespaceTitles[$namespace])) {
            return $this->namespaceTitles[$namespace];
        } else {
            throw new \DomainException("Title of namespace '$namespace' not found");
        }
    }

    /**
     * Adiciona mensagens da requisição corrente como se fosse de requisições
     * anteriores.
     * Utilizado para mensagens de erro que devem ser visualizadas na mesma
     * requisição. Mas mensagens de outros namespaces poderão ser adicionadas
     * no método __invoke.
     *
     * @param string $namespace            
     */
    private function mergeMessagesFromNamespace($namespace)
    {
        $helper = $this->getRender();
        $plugin = $helper->getPluginFlashMessenger();
        
        $refl = new \ReflectionClass($plugin);
        $prop = $refl->getProperty('messages');
        $prop->setAccessible(true);
        $val = $prop->getValue($plugin);
        
        if (isset($plugin->getContainer()->{$namespace})) {
            if (! isset($val[$namespace])) {
                $val[$namespace] = new \Zend\Stdlib\SplQueue();
            }
            foreach ($plugin->getCurrentMessagesFromNamespace($namespace) as $msg) {
                $val[$namespace]->push($msg);
            }
            $prop->setValue($plugin, $val);
            $plugin->clearCurrentMessagesFromNamespace($namespace);
        }
    }
}



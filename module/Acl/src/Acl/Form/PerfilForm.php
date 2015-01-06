<?php

namespace Acl\Form;

use Zend\Form\Form;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByReference;

class PerfilForm extends Form implements ObjectManagerAwareInterface
{

    /**
     *
     * @var \Autenticacao\Entity\Usuario
     */
    protected $usuario;
    
    public function __construct(ObjectManager $objectManager, $identity)
    {
        parent::__construct('perfil');

        $this->setObjectManager($objectManager);
        $this->setUsuario($identity);

        $this->setHydrator(new DoctrineObject($objectManager))->setObject(new \Acl\Entity\Perfil());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'nome',
            'attributes' => array(
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe o nome'
            ),
            'options' => array(
                'label' => 'Nome',
            )
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'funcaoAcao',
            'options' => array(
                'label' => 'Funções:',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Acl\Entity\FuncaoAcao',
                'label_generator' => function (\Acl\Entity\FuncaoAcao $funcaoAcao) {
                    return $funcaoAcao->getAcao()->getNome();
                },
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findPermissionByPerfil',
                    'params' => array(
                		'perfil' => $this->getUsuario()->getPerfil()
                    )                    
                )
            )
        ));

        $this->getHydrator()->addStrategy('FuncaoAcao', new AllowRemoveByReference());
    }

    /**
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager            
     * @return \Acl\Form\PerfilForm
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }
    
    /**
     * 
     * @return \Autenticacao\Entity\Usuario
     */
    public function getUsuario()
    {
    	return $this->usuario;
    }
    
    /**
     * 
     * @param \Autenticacao\Entity\Usuario $usuario
     * @return \Acl\Form\PermissaoForm
     */
    public function setUsuario(\Autenticacao\Entity\Usuario $usuario)
    {
    	$this->usuario = $usuario;
    	return $this;
    }    

}

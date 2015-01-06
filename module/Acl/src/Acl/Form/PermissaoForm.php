<?php

namespace Acl\Form;

use Zend\Form\Form;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByReference;

class PermissaoForm extends Form implements ObjectManagerAwareInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('perfil');

        $this->setObjectManager($objectManager);

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
                    return $funcaoAcao->getAcao()->getDescricao();
                },
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findPermission',
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

}

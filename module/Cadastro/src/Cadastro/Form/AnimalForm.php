<?php
namespace Cadastro\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

/**
 *
 * @author Jerfeson Guerreiro
 * @category Form
 * @package Cadastro/Form
 * @version 1.0.0
 */
class AnimalForm extends Form implements InputFilterProviderInterface
{

    /**
     * 
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function __construct(\Doctrine\Common\Persistence\ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        
        parent::__construct('animal');
        
        $this->setHydrator(new DoctrineObject($objectManager))->setObject(new \Cadastro\Entity\Animal());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'nome',
            'attributes' => array(
                'maxlength' => 100,
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe o nome'
            ),
            'options' => array(
                'label' => 'Nome',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'nomeCientifico',
            'attributes' => array(
                'maxlength' => 100,
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe o nome científico'
            ),
            'options' => array(
                'label' => 'Nome científico',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'estadoConservacao',
            'attributes' => array(
                'maxlength' => 100,
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe o estado de conservação'
            ),
            'options' => array(
                'label' => 'Conservação',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'descricao',
            'attributes' => array(
                'maxlength' => 2000,
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe a descrição'
            ),
            'options' => array(
                'label' => 'Descrição',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'localizacaoY',
            'attributes' => array(
                'maxlength' => 200,
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe a localização Y do animal'
            ),
            'options' => array(
                'label' => 'Localização Y',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'localizacaoX',
            'attributes' => array(
                'maxlength' => 200,
                'required' => true,
                'type' => 'text',
                'placeholder' => 'Informe a localização X do animal'
            ),
            'options' => array(
                'label' => 'Localização X',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));        
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'alimentacao',
            'options' => array(
                'label' => 'Alimentação',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                ),
                'column-size' => 'sm-2',
                'object_manager' => $objectManager,
                'target_class' => 'Cadastro\Entity\Alimentacao',
                'display_empty_item' => true,
                'label_generator' => function ($obj)
                {
                    return $obj->getNome();
                },
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array(
                            'nome' => 'ASC'
                        )
                    )
                )
            ),
            'attributes' => array(
                'placeholder' => 'Selecione a alimentação'
            )
        ));
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'ambiente',
            'options' => array(
                'label' => 'Ambiente',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                ),
                'column-size' => 'sm-2',
                'object_manager' => $objectManager,
                'target_class' => 'Cadastro\Entity\Ambiente',
                'display_empty_item' => true,
                'label_generator' => function ($obj)
                {
                    return $obj->getNome();
                },
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array(
                            'nome' => 'ASC'
                        )
                    )
                )
            ),
            'attributes' => array(
                'placeholder' => 'Selecione o ambiente'
            )
        ));
        
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'atividade',
            'options' => array(
                'label' => 'Atividade',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                ),
                'column-size' => 'sm-2',
                'object_manager' => $objectManager,
                'target_class' => 'Cadastro\Entity\Atividade',
                'display_empty_item' => true,
                'label_generator' => function ($obj)
                {
                    return $obj->getNome();
                },
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array(
                            'nome' => 'ASC'
                        )
                    )
                )
            ),
            'attributes' => array(
                'placeholder' => 'Selecione a atividade'
            )
        ));
                
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'recinto',
            'options' => array(
                'label' => 'Recinto',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                ),
                'column-size' => 'sm-2',
                'object_manager' => $objectManager,
                'target_class' => 'Cadastro\Entity\Recinto',
                'display_empty_item' => true,
                'label_generator' => function ($obj)
                {
                    return $obj->getNome();
                },
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array(
                            'nome' => 'ASC'
                        )
                    )
                )
            ),
            'attributes' => array(
                'placeholder' => 'Selecione o recinto'
            )
        ));
                
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'arquivo',
            'attributes' => array(
                'type' => 'file',
                'placeholder' => 'Selecione a imagem'
            ),
            'options' => array(
                'label' => 'Imagem',
                'column-size' => 'sm-4',
                'label_attributes' => array(
                    'class' => 'col-sm-2 label-required'
                )
            )
        ));
                                
        $this->add(array(
            'type' => 'Cadastro\Form\Fieldset\Botoes',
            'name' => 'botoes',
            'options' => array(
                'column-size' => 'sm-12',
                'label_attributes' => array(
                    'class' => 'col-sm-12'
                ),
                'twb-layout' => \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_INLINE,
            ),
            'attributes' => array(
                'class' => 'botoes col-sm-offset-2 col-sm-10'
            ),
        ));    
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification()
    {
        return array(
            'nome' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 5,
                            'max' => 100,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => \Application\Common\Message::TOO_SHORT('O nome'),
                                \Zend\Validator\StringLength::TOO_LONG => \Application\Common\Message::TOO_LONG('O nome')
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('Cadastro\Entity\Animal'),
                            'object_manager' => $this->objectManager,
                            'fields' => 'nome',
                            'messages' => array(
                                \DoctrineModule\Validator\UniqueObject::ERROR_OBJECT_NOT_UNIQUE => \Application\Common\Message::NOT_UNIQUE('um animal', 'esse nome')
                            )                            
                        )
                    )
                )
            ),
            'nomeCientifico' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 5,
                            'max' => 100,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => \Application\Common\Message::TOO_SHORT('O nome'),
                                \Zend\Validator\StringLength::TOO_LONG => \Application\Common\Message::TOO_LONG('O nome científico')
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('Cadastro\Entity\Animal'),
                            'object_manager' => $this->objectManager,
                            'fields' => 'nomeCientifico',
                            'messages' => array(
                                \DoctrineModule\Validator\UniqueObject::ERROR_OBJECT_NOT_UNIQUE => \Application\Common\Message::NOT_UNIQUE('um animal', 'esse nome científico')
                            )                            
                        )
                    )
                )
            ),
        );
    }
}


<?php
namespace Cadastro;

return array(
    'router' => array(
        'routes' => array(
            'cadastro' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/cadastro',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Cadastro\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Cadastro\Controller\Index' => 'Cadastro\Controller\IndexController',
            'Cadastro\Controller\Alimentacao' => 'Cadastro\Controller\AlimentacaoController',
            'Cadastro\Controller\Ambiente' => 'Cadastro\Controller\AmbienteController',
            'Cadastro\Controller\Atividade' => 'Cadastro\Controller\AtividadeController',
            'Cadastro\Controller\Recinto' => 'Cadastro\Controller\RecintoController',
            'Cadastro\Controller\Animal' => 'Cadastro\Controller\AnimalController',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);

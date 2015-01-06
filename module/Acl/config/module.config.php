<?php
namespace Acl;

return array(
    'router' => array(
        'routes' => array(
            'acl' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/acl[/:controller[/:action[/:id]]][/]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z-]*',
                        'action' => '[a-zA-Z][a-zA-Z]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Acl\Controller',
                        'action' => 'index'
                    )
                )
            ),
            'permissao' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/error/permissao',
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Error',
                        'action' => 'permissao'
                    )
                )
            ),
            'alterar-senha' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/alterar-senha/',
                    'defaults' => array(
                        'controller' => 'Cadastro\Controller\Parametro',
                        'action' => 'senha'
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Acl\Controller\Index' => 'Acl\Controller\IndexController',
            'Acl\Controller\Error' => 'Acl\Controller\ErrorController',
            'Acl\Controller\Permissao' => 'Acl\Controller\PermissaoController',
            'Acl\Controller\Perfil' => 'Acl\Controller\PerfilController',
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
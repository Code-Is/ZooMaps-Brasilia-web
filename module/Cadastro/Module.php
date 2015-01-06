<?php

namespace Cadastro;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /**
                 * Model Factories
                 */
                'Cadastro\Model\AlimentacaoModel' => function ($sm) {
                    return new \Cadastro\Model\AlimentacaoModel($sm->get('EntityManager'));
                },
                'Cadastro\Model\AmbienteModel' => function ($sm) {
                    return new \Cadastro\Model\AmbienteModel($sm->get('EntityManager'));
                },
                'Cadastro\Model\AnimalModel' => function ($sm) {
                    return new \Cadastro\Model\AnimalModel($sm->get('EntityManager'));
                },
                'Cadastro\Model\AtividadeModel' => function ($sm) {
                    return new \Cadastro\Model\AtividadeModel($sm->get('EntityManager'));
                },
                'Cadastro\Model\RecintoModel' => function ($sm) {
                    return new \Cadastro\Model\RecintoModel($sm->get('EntityManager'));
                },
                /**
                 * Form Factories
                 */
                'Cadastro\Form\AlimentacaoForm' => function ($sm) {
                    return new \Cadastro\Form\AlimentacaoForm($sm->get('EntityManager'));
                },
                'Cadastro\Form\AmbienteForm' => function ($sm) {
                    return new \Cadastro\Form\AmbienteForm($sm->get('EntityManager'));
                },
                'Cadastro\Form\AnimalForm' => function ($sm) {
                    return new \Cadastro\Form\AnimalForm($sm->get('EntityManager'));
                },
                'Cadastro\Form\AtividadeForm' => function ($sm) {
                    return new \Cadastro\Form\AtividadeForm($sm->get('EntityManager'));
                },
                'Cadastro\Form\RecintoForm' => function ($sm) {
                    return new \Cadastro\Form\RecintoForm($sm->get('EntityManager'));
                },
                /**
                 * DataTable Factories
                 */
                'Cadastro\ZfTable\Alimentacao' => function ($sm) {
                    $repo = $sm->get('EntityManager')->getRepository('Cadastro\Entity\Alimentacao');
                    return new \Cadastro\ZfTable\Alimentacao($repo, $sm->get('Request')->getPost());
                },
                'Cadastro\ZfTable\Ambiente' => function ($sm) {
                    $repo = $sm->get('EntityManager')->getRepository('Cadastro\Entity\Ambiente');
                    return new \Cadastro\ZfTable\Ambiente($repo, $sm->get('Request')->getPost());
                },
                'Cadastro\ZfTable\Animal' => function ($sm) {
                    $repo = $sm->get('EntityManager')->getRepository('Cadastro\Entity\Animal');
                    return new \Cadastro\ZfTable\Animal($repo, $sm->get('Request')->getPost());
                },
                'Cadastro\ZfTable\Atividade' => function ($sm) {
                    $repo = $sm->get('EntityManager')->getRepository('Cadastro\Entity\Atividade');
                    return new \Cadastro\ZfTable\Atividade($repo, $sm->get('Request')->getPost());
                },
                'Cadastro\ZfTable\Recinto' => function ($sm) {
                    $repo = $sm->get('EntityManager')->getRepository('Cadastro\Entity\Recinto');
                    return new \Cadastro\ZfTable\Recinto($repo, $sm->get('Request')->getPost());
                },
            )
        );
    }
}

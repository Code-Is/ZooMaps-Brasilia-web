<?php

/**
 *
 * @author    Jerfeson Guerreiro
 * @category  Model
 * @package   Cadastro/Model
 * @version   1.0.0
 */

namespace Cadastro\Model;

class AnimalModel extends \Application\Model\Model
{

    /**
     * Entidade relacionada
     * @var string
     */
    const ENTITY = 'Cadastro\Entity\Animal';

    public function save($data)
    {
        $arquivo = $data->getArquivo();
        
        if ($arquivo['name'] != '') {

            $httpadapter = new \Zend\File\Transfer\Adapter\Http();

            $filesize = new \Zend\Validator\File\Size(array(
                'max' => '2MB'
            ));

            $extension = new \Zend\Validator\File\Extension(array(
                'extension' => array(
                    'jpg', 'jpeg',
                    'gif', 'png'
                )
            ));

            $ext = pathinfo($arquivo['name'], PATHINFO_EXTENSION);

            $httpadapter->setValidators(array($filesize, $extension), $arquivo['name']);
            $httpadapter->addFilter('Rename', array(
                'target' => './public/uploads/animais/' . $data->getId() . '.' . $ext,
                'overwrite' => true
            ));

            if ($httpadapter->isValid()) {
                $httpadapter->setDestination('./public/uploads/animais/');
                if ($httpadapter->receive($arquivo['name'])) {
                    $file = $httpadapter->getFileName();
                    $data->setImagem($file);
                } else {
                    throw new \Exception("Falha ao fazer upload do arquivo");
                }
            } else {
                throw new \Exception("Arquivo de imagem inválido");
            }
        }

        parent::save($data);
    }

}

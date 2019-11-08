<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bag\Entity\Material;

class ImagemController extends AbstractActionController
{
    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
	
    public function gridModalAction() {
        $materialId = $this->params()->fromQuery('id', 0);
        $material = $this->entityManager->find(Material::class, $materialId);
        $view = new ViewModel([
            'imagens' => $material->getImagens(),
            'material' => $material
        ]);
        return $view->setTerminal(true);
    }	
    
    public function testeserialAction()
    {
        return new ViewModel([
        ]);	

    }
}

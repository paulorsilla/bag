<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\MaterialTipoBagForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\MaterialTipoBag;
use Bag\Entity\Material;
use Zend\View\Model\JsonModel;

class MaterialTipoBagController extends AbstractActionController
{
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;

        private $objectManager;
	
	/**
	 * Construtor da classe, utilizado para injetar as dependências
	 */
	public function __construct($entityManager, $objectManager)
	{
            $this->entityManager = $entityManager;
            $this->objectManager = $objectManager;
	}
	
        public function gridModalAction()
	{
            $materialId = $this->params()->fromQuery('materialId', 0);
            $material = $this->entityManager->find(Material::class, $materialId);
            $view = new ViewModel([
                'material' => $material,
            ]);
            return $view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = $this->params()->fromQuery('id');
                if ( !empty($id) ) {
                    $materialTipoBag = $this->entityManager->find(MaterialTipoBag::class, $id);
                    $materialId = $materialTipoBag->getMaterial()->getId();
                } else {
                    $materialTipoBag = null;
                    $materialId = $this->params()->fromQuery('materialId');
                }
                
		//Cria o formulário
		$form = new MaterialTipoBagForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
                    
                    //Recebe os dados via POST
                    $data = $this->params()->fromPost();

                    //Preenche o form com os dados recebidos e o valida
                    $form->setData($data);
                    if ($form->isValid()) {
                        $data = $form->getData();
                        $repo = $this->entityManager->getRepository(MaterialTipoBag::class);
                        $repo->incluir_ou_editar($data, $id, $materialId);
                        
                        // alterar para json
                        $modelJson = new JsonModel();
                        $modelJson->setVariable('materialId', $materialId);
                        $modelJson->setVariable('success', 1);
                        return $modelJson;
                    }
		} else {
                    if (null != $materialTipoBag) {
                        $form->setData($materialTipoBag->toArray());
                    }
                }
                $view = new ViewModel([
                    'form' => $form
		]);
		return $view->setTerminal(true);
	}
        
        public function deleteModalAction()
        {
            $id = $this->params()->fromQuery('id');
            if ($this->getRequest()->isPost()) {
                $repo = $this->entityManager->getRepository(MaterialTipoBag::class);
                $materialId = $repo->delete($id);
                $modelJson = new \Zend\View\Model\JsonModel();
                $modelJson->setVariable('materialId', $materialId);
                $modelJson->setVariable('success', 1);
                return $modelJson;
            }
            $materialTipoBag = $this->entityManager->find(MaterialTipoBag::class, $id);
            $view = new ViewModel([
                'materialTipoBag' => $materialTipoBag,
            ]);
                return $view->setTerminal(true);
        }
}

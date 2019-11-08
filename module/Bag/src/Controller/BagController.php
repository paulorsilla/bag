<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\BagForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Bag;
use Bag\Entity\Material;
use Zend\View\Model\JsonModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class BagController extends AbstractActionController
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
        
        public function indexAction()
        {
            $repo = $this->entityManager->getRepository(Bag::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromQuery();
            $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(10);        
            $paginator->setCurrentPageNumber($page);

            return new ViewModel([
                'bags' => $paginator,
                'search' => $search
            ]);	            
        }
	
        public function gridModalAction()
	{
            $id = $this->params()->fromQuery('id', 0);
            $material = $this->entityManager->find(Material::class, $id);
            $view = new ViewModel([
                'material' => $material
            ]);
            return $view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $id = $this->params()->fromRoute('id', null);
                $materialId = $this->params()->fromQuery('materialId');
                
		//Cria o formulário
		$form = new BagForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
                    
                    //Recebe os dados via POST
                    $data = $this->params()->fromPost();
                    unset($data['modulo']);
                    unset($data['lado']);
                    unset($data['face']);
                    unset($data['nivel']);
                    unset($data['espaco']);

                    //Preenche o form com os dados recebidos e o valida
                    $form->setData($data);
                    if ($form->isValid()) {
                        $data = $form->getData();
                        $repo = $this->entityManager->getRepository(Bag::class);
                        $repo->incluir_ou_editar($data, $id, $materialId);
                        
                        // alterar para json
                        $modelJson = new JsonModel();
                        $modelJson->setVariable('materialId', $materialId);
                        $modelJson->setVariable('success', 1);
                        return $modelJson;
                    }
		} else {
                    if (null != $materialId) {
                        $material = $this->entityManager->find(Material::class, $materialId);
                        $row = $material->getBag();
                        if ( !empty($row)){
//                            $pesoSem = str_replace(".", ",", $row->getPesoSem());
                            $form->setData($row->toArray());
                            $form->get("localizacao")->setValue($row->getLocalizacao()->getLocalizacao());
//                            $form->get("pesoSem")->setValue($pesoSem);
                        }
                    }
                }
                $view = new ViewModel([
                    'form' => $form
		]);
		return $view->setTerminal(true);
	}
        
        public function deleteModalAction()
        {
            $materialId = $this->params()->fromQuery('materialId');
            if ($this->getRequest()->isPost()) {
                $repo = $this->entityManager->getRepository(Bag::class);
                $repo->delete(null, $materialId);
                $modelJson = new \Zend\View\Model\JsonModel();
                $modelJson->setVariable('materialId', $materialId);
                $modelJson->setVariable('success', 1);
                return $modelJson;
            }
            $material = $this->entityManager->find(Material::class, $materialId);
            $view = new ViewModel([
                'bag' => $material->getBag(),
            ]);
            return $view->setTerminal(true);
        }
}

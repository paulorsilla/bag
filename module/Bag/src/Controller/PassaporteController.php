<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\PassaporteForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Passaporte;
use Bag\Entity\Material;
use Bag\Entity\Instituicao;
use Zend\View\Model\JsonModel;

class PassaporteController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Passaporte::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page,$search);

            return new ViewModel([
                'passaportes' => $paginator,
            ]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            //Cria o formulário
            $form = new PassaporteForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Passaporte::class);
                    $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('bag/passaporte', ['action' => 'save']);
                }
            } else {
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Passaporte::class);
                    $row = $repo->find($id);
                    if ( !empty($row)){
                        $form->setData($row->toArray());
                    }
                }
            }
            return new ViewModel([
                'form' => $form
            ]);
	}
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/passaporte');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Passaporte::class);
            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/passaporte');
            }
            $passaporte = $repo->find($id);

            return new ViewModel([
                'passaporte' => $passaporte,
            ]);
	}
        
        public function gridModalAction()
	{
            $id = $this->params()->fromQuery('id', 0);
            $material = $this->entityManager->find(Material::class, $id);
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
                $id = $this->params()->fromRoute('id', null);
                $materialId = $this->params()->fromQuery('materialId');
                
		//Cria o formulário
		$form = new PassaporteForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
                    
                    //Recebe os dados via POST
                    $data = $this->params()->fromPost();

                    //Preenche o form com os dados recebidos e o valida
                    $form->setData($data);
                    if ($form->isValid()) {
                        $data = $form->getData();
                        $repo = $this->entityManager->getRepository(Passaporte::class);
                        $repo->incluir_ou_editar($data, $id, $materialId);
                        
                        // alterar para json
                        $modelJson = new JsonModel();
                        $modelJson->setVariable('materialId', $materialId);
                        $modelJson->setVariable('success', 1);
                        return $modelJson;
                    }
		} else {
                    error_log("aqui...");
                    if (null != $materialId) {
                        error_log($materialId);
                        $material = $this->entityManager->find(Material::class, $materialId);
                        $row = $material->getPassaporte();
                        if ( !empty($row)) {
                            $form->setData($row->toArray());
                            if(null != $row->getPais()) {
                                $form->get("pais")->setValue($row->getPais()->getId());
                            }
                            if (!empty($row->getEstado())) {
                                $form->get("estado")->setValue($row->getEstado()->getId());
                            }
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
                $repo = $this->entityManager->getRepository(Passaporte::class);
                $repo->delete(null, $materialId);
                $modelJson = new \Zend\View\Model\JsonModel();
                $modelJson->setVariable('materialId', $materialId);
                $modelJson->setVariable('success', 1);
                return $modelJson;
            }
            $material = $this->entityManager->find(Material::class, $materialId);
            $view = new ViewModel([
                'passaporte' => $material->getPassaporte(),
            ]);
                return $view->setTerminal(true);
        }
}

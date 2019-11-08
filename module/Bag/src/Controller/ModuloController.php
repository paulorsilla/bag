<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\ModuloForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Modulo;

class ModuloController extends AbstractActionController
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
	
	public function indexAction()
	{
            $repo = $this->entityManager->getRepository(Modulo::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);
            return new ViewModel([
                'modulos' => $paginator,
            ]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            //Cria o formulário
            $form = new ModuloForm();
            $repo = $this->entityManager->getRepository(Modulo::class);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('bag/modulo', ['action' => 'save']);
                }
            } else {
                if ( !empty($id)){
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
                return $this->redirect()->toRoute('bag/modulo');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Modulo::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/modulo');
            }
            $modulo = $repo->find($id);

            return new ViewModel([
                'modulo' => $modulo,
            ]);
	}

        public function consultaAction()
        {
            $request = $this->getRequest();
            $response = $this->getResponse();
            $response->setContent(\Zend\Json\Json::encode([
                        'dataType' => 'json',
                        'response' => false]));
            
            if ($request->isPost()) {
                $id = (int) $this->params()->fromPost('id');
                error_log($id);
                $repo = $this->entityManager->getRepository(Modulo::class);
                $modulo = $repo->find($id);
                $response->setContent(\Zend\Json\Json::encode([
                    'dataType' => 'json',
                    'lados' => $modulo->getLados(),
                    'faces' => $modulo->getFaces(),
                    'niveis' => $modulo->getNiveis(),
                    'espacos' => $modulo->getEspacos(),
                    'response' => true]));

            }
            return $response;
        }
}

<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bag\Entity\Instituicao;
use Bag\Form\InstituicaoForm;
use User\Entity\User;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;


class InstituicaoController extends AbstractActionController
{
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;
        
        private $objectManager;

	
	/**
	 * Construtor da classe, utilizado para injetar as dependências no controller
	 */
        public function __construct($entityManager, $objectManager)
	{
            $this->entityManager = $entityManager;
            $this->objectManager = $objectManager;
	}

        
	public function indexAction()
	{
            $repo = $this->entityManager->getRepository(Instituicao::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);
            
            return new ViewModel([
                'instituicoes' => $paginator,
            ]);	
	}
        
        /**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            //Cria o formulário
            $form = new InstituicaoForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();

                    $user = $this->entityManager->getRepository(User::class)->findOneByLogin($this->identity());
                    $data['login'] = $user->getLogin();
                    $data['dataAtual'] = date("Y-m-d H:i:s");


                    $repo = $this->entityManager->getRepository(Instituicao::class);
                    $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('bag/instituicao', ['action' => 'index']);
                }
            } else {
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Instituicao::class);
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
}

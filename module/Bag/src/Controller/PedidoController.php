<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\PedidoForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Pedido;
use Bag\Entity\Instituicao;
use Bag\Entity\ItemPedido;
use Zend\View\Model\JsonModel;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class PedidoController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Pedido::class);
            $repoInstituicao = $this->entityManager->getRepository(Instituicao::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromQuery();
            $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(10);        
            $paginator->setCurrentPageNumber($page);
            $instituicoes = [];
            foreach($paginator as $pedido) {
                if (null != $pedido->getInstituicao()) {
                    $instituicoes[$pedido->getId()] = $repoInstituicao->find($pedido->getInstituicao());
                }
            }

            return new ViewModel([
                'pedidos' => $paginator,
                'search' => $search,
                'instituicoes' => $instituicoes
            ]);	
	}
        
     	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            $row = null;
            
            //Cria o formulário
            $form = new PedidoForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Pedido::class);
                    $row = $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('bag/pedido', ['action' => 'save', 'id' => $row->getId()]);
                }
            } else {
                if ( !empty($id) ) {
                    $repo = $this->entityManager->getRepository(Pedido::class);
                    $row = $repo->find($id);
                    if ( !empty($row)) {
                        $form->setData($row->toArray());
                    }
                }
            }
            return new ViewModel([
                'form' => $form,
                'pedido' => $row
            ]);
	}
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/pedido');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Pedido::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/pedido');
            }
            $pedido = $repo->find($id);

            return new ViewModel([
                'pedido' => $pedido,
            ]);
	}
        
    public function closeModalAction() 
    {
        $id = $this->params()->fromQuery('id');
        if (!empty($id)) {
            $pedido = $this->entityManager->find(Pedido::class, $id);
        }
        if ($pedido && $this->getRequest()->isPost() && $pedido->getStatus() == 1 ) {
            
            foreach($pedido->getItens() as $itemPedido) {
                $bag = $itemPedido->getMaterial()->getBag();
                $quantidadeAtendida = $itemPedido->getQuantidadeAtendida();
                $pesoSem = $bag->getPesoSem();
                $pesoBaixa = ($pesoSem * $quantidadeAtendida) / 100;
                $pesoTotalAtualizado = $bag->getPesoTotal() - $pesoBaixa;
                $bag->setPesoTotal($pesoTotalAtualizado);
                $this->entityManager->persist($bag);
            }
            
            $pedido->setStatus(2);
            $this->entityManager->persist($pedido);
            
            $this->entityManager->flush();
            $modelJson = new \Zend\View\Model\JsonModel();
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
        $view = new ViewModel([
            'pedido' => $pedido,
        ]);
        return $view->setTerminal(true);
    }
    
        public function printAction() 
        {
            $id = $this->params()->fromRoute('id');
            $pedido = null;
            if (!empty($id)) {
                $pedido = $this->entityManager->find(Pedido::class, $id);
            }
            $this->layout ()->setTemplate ( "layout/layout-relatorio" )->setVariable ( "titulo_impressao", "Saída de Sementes" );
            $repoItem = $this->entityManager->getRepository(ItemPedido::class);
            $itens = $repoItem->getQuery(['pedido' => $pedido->getId()]);
            $instituicao = (null != $pedido->getInstituicao()) ? $this->entityManager->find(Instituicao::class, $pedido->getInstituicao()) : null;
            
            return new ViewModel([
                'pedido' => $pedido,
                'itens' => $itens,
                'instituicao' => $instituicao
            ]);
        }
        
        public function attachAtmAction()
        {
            if ($this->getRequest()->isPost()) {
                $pedidoId = $this->params()->fromPost('pedidoId');
                $file = $this->params()->fromFiles('arquivo');

                $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\Bag\Service\FileUpload::class);
                $serviceImportacao->uploadAtm($file, $pedidoId);
            }
            $modelJson = new JsonModel();
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
        
        public function  readAtmAction()
        {
            $id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
            if ($id == 0) {
                throw new \Exception ( "Código obrigatório" );
            }
            $pedido = $this->entityManager->find (Pedido::class, $id );
            $nomeAux = trim($pedido->getAnexoAtm());
            $nome = str_replace(" ", "%20", $nomeAux);

            if ($pedido) {
                $path = "/home/aplicacoes/bagarquivos/atm/" . $nome;
                return new ViewModel ( array (
                    'conteudo' => file_get_contents ( $path ),
                    'size' => filesize ( $path ),
                    'type' => pathinfo ( $path, PATHINFO_EXTENSION ),
                    'filename' => $pedido->getAnexoAtm()
                ) );
            }
        }
}

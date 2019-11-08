<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\AvaliacaoForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Avaliacao;
use Bag\Entity\ItemAvaliacao;
use Bag\Entity\Regeneracao;
use Zend\View\Model\JsonModel;
use Bag\Repository\MaterialCaracteristica;

class AvaliacaoController extends AbstractActionController
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
            $idRegeneracao = (int) $this->params()->fromRoute('id', null);
            $regeneracao = $this->entityManager->find(Regeneracao::class, $idRegeneracao);

            $repo = $this->entityManager->getRepository(Avaliacao::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $search['regeneracao'] = $idRegeneracao;
            $paginator = $repo->getPaginator($page, $search);

            return new ViewModel([
                'avaliacoes' => $paginator,
                'regeneracao' => $regeneracao
            ]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            $idRegeneracao = $this->params()->fromRoute('idRegeneracao', null);
            
            //Cria o formulário
            $form = new AvaliacaoForm($this->objectManager, $idRegeneracao);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Avaliacao::class);
                    $repoItens = $this->entityManager->getRepository(ItemAvaliacao::class); 
                    $avaliacao = $repo->incluir_ou_editar($data, $id, $idRegeneracao);
                    $repoItens->incluir($idRegeneracao, $avaliacao->getId());
                    return $this->redirect()->toRoute('bag/avaliacao', ['action' => 'index', 'idRegeneracao' => $idRegeneracao ]);
                }
            } else {
                if ( !empty($id)) {
                    $repo = $this->entityManager->getRepository(Avaliacao::class);
                    $row = $repo->find($id);
                    if ( !empty($row)) {
                        $form->setData($row->toArray());
                    }
                }
            }
            $regeneracao = $this->entityManager->find(Regeneracao::class, $idRegeneracao);
            return new ViewModel([
                'form' => $form,
                'regeneracao' => $regeneracao
            ]);
	}
        
//        public function buscaCaracteristicasAction()
//        {
//            $idRegeneracao = (int) $this->params()->fromPost('idRegeneracao');
//            $regeneracao = $this->entityManager->find(Regeneracao::class, $idRegeneracao);
//            $repo = $this->entityManager->getRepository(Coleta::class);
//            $search = ['regeneracao' => $regeneracao->getId()];
//            $coletas = $repo->getQuery($search)->getQuery()->getResult();
//            $options = "";
//            $caracteristicas = [];
//            
//            foreach($coletas as $coleta) {
//                foreach($coleta->getCaracteristicas() as $c) {
//                    array_push($caracteristicas, $c);
//                }
//            }
//
//            foreach($regeneracao->getCaracteristicas() as $caracteristica) {
//                if (!in_array($caracteristica, $caracteristicas)) {
//                    $options .= "<option value=".$caracteristica->getId().">".$caracteristica->getNomeCurto()."</option>"; 
//                }
//            }
//            
//            // alterar para json
//            $modelJson = new JsonModel();
//            $modelJson->setVariable('options', $options);
//            $modelJson->setVariable('success', 1);
//            return $modelJson;
//        }
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/avaliacao');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Avaliacao::class);
            $avaliacao = $repo->find($id);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/avaliacao', ['action' => 'index', 'idRegeneracao' => $avaliacao->getRegeneracao()->getId() ]);
            }
            return new ViewModel([
                'avaliacao' => $avaliacao,
            ]);
	}
        
        public function collectAction()
        {
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/avaliacao');
            }
            $repo = $this->entityManager->getRepository(Avaliacao::class);
            $repoItensAvaliacao = $this->entityManager->getRepository(ItemAvaliacao::class);
            $repoMaterialCaracteristica = $this->entityManager->getRepository(MaterialCaracteristica::class);
            $avaliacao = $repo->find($id);
            
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();
                foreach($data as $k => $valor) {
                    $idItemAvaliacao = explode("_", $k);
                    $itemAvaliacao = $repoItensAvaliacao->find($idItemAvaliacao[1]);
                    if ($itemAvaliacao) {
                        $repoItensAvaliacao->atualizar($itemAvaliacao, $valor);
                    }
                }
            }
            $itensAvaliacao = [];
            $caracteristicas = $avaliacao->getCaracteristicas();
            $itens = $avaliacao->getRegeneracao()->getItens();
            foreach($itens as $item) {
                foreach($caracteristicas as $caracteristica) {
                    $itemAvaliacao = $repoItensAvaliacao->findOneBy(['avaliacao' => $avaliacao, 'caracteristica' => $caracteristica, 'itemRegeneracao' => $item]);
                    if ( $itemAvaliacao ) {
                        $materialCaracteristica = $repoMaterialCaracteristica->findOneBy(['caracteristica' => $caracteristica, 'material' => $itemAvaliacao->getItemRegeneracao()->getMaterial()]);
                        $valorMaterialCaracteristica = "";
                        if ($materialCaracteristica) {
                            $valorMaterialCaracteristica = $materialCaracteristica->getValor();
                        }
                        $itensAvaliacao[$item->getId().":".$caracteristica->getId()] = [
                            'id' => $itemAvaliacao->getId(),
                            'valor' => $itemAvaliacao->getValor(),
                            'caracteristicaNomeCurto' => $caracteristica->getNomeCurto(),
                            'valorMaterialCaracteristica' => $valorMaterialCaracteristica
                        ];
                    }
                }
            }
            return new ViewModel([
               'avaliacao' => $avaliacao,
               'itensAvaliacao' => $itensAvaliacao
            ]);
        }
        
        public function updateitemAction()
        {
            if ($this->getRequest()->isPost()) {
                $id = $this->params()->fromPost('id');
                $valor = $this->params()->fromPost('valor');
                $repoItensAvaliacao = $this->entityManager->getRepository(ItemAvaliacao::class);
                $itemAvaliacao = $repoItensAvaliacao->find($id);
                $repoItensAvaliacao->atualizar($itemAvaliacao, $valor);
            }
            
            // alterar para json
            $modelJson = new JsonModel();
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
}

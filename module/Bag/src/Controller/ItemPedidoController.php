<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\ItemPedidoForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Pedido;
use Zend\View\Model\JsonModel;
use Bag\Entity\ItemPedido;
use Bag\Entity\Material;

class ItemPedidoController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $objectManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências
     */
    public function __construct($entityManager, $objectManager) {
        $this->entityManager = $entityManager;
        $this->objectManager = $objectManager;
    }

    public function gridModalAction() {
        $pedidoId = $this->params()->fromQuery('id', 0);
        $pedido = $this->entityManager->find(Pedido::class, $pedidoId);
        $view = new ViewModel([
            'pedido' => $pedido,
        ]);
        return $view->setTerminal(true);
    }

    /**
     * Action para salvar um novo registro
     */
    public function saveModalAction() {
        $id = $this->params()->fromQuery('id');
        $pesquisaCgs = $this->params()->fromQuery('pesquisaCgs');
        $pesquisaAcesso = $this->params()->fromQuery('pesquisaAcesso');
        $pesquisaSinonimia = $this->params()->fromQuery('pesquisaSinonimia');
        if (!empty($id)) {
            $itemPedido = $this->entityManager->find(ItemPedido::class, $id);
            $pedidoId = $itemPedido->getPedido()->getId();
            $pesquisaCgs = $itemPedido->getMaterial()->getCgs();
        } else {
            $itemPedido = null;
            $pedidoId = $this->params()->fromQuery('pedidoId');
        }

        //Cria o formulário
        $form = new ItemPedidoForm($this->objectManager, $pesquisaCgs, $pesquisaAcesso, $pesquisaSinonimia);

        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repo = $this->entityManager->getRepository(ItemPedido::class);
                $repo->incluir_ou_editar($data, $id, $pedidoId);

                // alterar para json
                $modelJson = new JsonModel();
                $modelJson->setVariable('pedidoId', $pedidoId);
                $modelJson->setVariable('success', 1);
                return $modelJson;
            }
        } else {
            if (null != $itemPedido) {
                if($itemPedido->getMaterial()->getBag()->getPesoSem() > 0) {
                    $quantidadeAtual = (100 * $itemPedido->getMaterial()->getBag()->getPesoTotal()) / $itemPedido->getMaterial()->getBag()->getPesoSem();
                } else {
                    $quantidadeAtual = 0;
                }
                $form->get('quantidadeAtual')->setValue(number_format($quantidadeAtual, 2,',','.'));
                $form->setData($itemPedido->toArray());
            }
        }
        $view = new ViewModel([
            'form' => $form
        ]);
        return $view->setTerminal(true);
    }

    public function saveFileAction() {
        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {
            $pedidoId = $this->params()->fromPost('pedidoId');
            $file = $this->params()->fromFiles('arquivo');

            $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\Bag\Service\FileUpload::class);
            $dados = $serviceImportacao->uploadMaterial($file);
            $repo = $this->entityManager->getRepository(ItemPedido::class);

            foreach ($dados as $d) {
                $material = $this->entityManager->getRepository(Material::class)->findOneBy(['cgs' => $d['cgs']]);
                if ($material) {
                    $d['material'] = $material->getId();
                    $repo->incluir_ou_editar($d, NULL, $pedidoId);
                }
            }
        }
        $modelJson = new JsonModel();
        $modelJson->setVariable('success', 1);
        return $modelJson;

    }

    public function deleteModalAction() {
        $id = $this->params()->fromQuery('id');
        if (!empty($id)) {
            $itemPedido = $this->entityManager->find(ItemPedido::class, $id);
            $pedidoId = $itemPedido->getPedido()->getId();
        }
        if ($this->getRequest()->isPost()) {
            $repo = $this->entityManager->getRepository(ItemPedido::class);
            $repo->delete($id);
            $modelJson = new \Zend\View\Model\JsonModel();
            $modelJson->setVariable('pedidoId', $pedidoId);
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
//        $materialCaracteristica = $this->entityManager->find(MaterialCaracteristica::class, $id);
        $view = new ViewModel([
            'itemPedido' => $itemPedido,
        ]);
        return $view->setTerminal(true);
    }

}

<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\ItemRegeneracaoForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Regeneracao;
use Zend\View\Model\JsonModel;
use Bag\Entity\ItemRegeneracao;
use Bag\Entity\ItemRegeneracaoAcao;
use Bag\Entity\Material;

class ItemRegeneracaoController extends AbstractActionController {

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
        $regeneracaoId = $this->params()->fromQuery('id', 0);
        $regeneracao = $this->entityManager->find(Regeneracao::class, $regeneracaoId);
        $view = new ViewModel([
            'regeneracao' => $regeneracao,
        ]);
        return $view->setTerminal(true);
    }

    public function updateModalAction() {
        $regeneracaoId = $this->params()->fromQuery('id', 0);
        $regeneracao = $this->entityManager->find(Regeneracao::class, $regeneracaoId);
        
        //Cria o formulário
        $form = new ItemRegeneracaoForm($this->objectManager, "", "", "");
        
        $view = new ViewModel([
            'regeneracao' => $regeneracao,
            'form' => $form
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
        $buscarBanco = true;
        if ($pesquisaCgs == "" && $pesquisaAcesso == "" && $pesquisaSinonimia == "") {
            $buscarBanco = false;
        }
        
        if (!empty($id)) {
            $itemRegeneracao = $this->entityManager->find(ItemRegeneracao::class, $id);
            $regeneracaoId = $itemRegeneracao->getRegeneracao()->getId();
            $pesquisaCgs = $itemRegeneracao->getMaterial()->getCgs();
        } else {
            $itemRegeneracao = null;
            $regeneracaoId = $this->params()->fromQuery('regeneracaoId');
        }

        //Cria o formulário
        $form = new ItemRegeneracaoForm($this->objectManager, $pesquisaCgs, $pesquisaAcesso, $pesquisaSinonimia);

        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repo = $this->entityManager->getRepository(ItemRegeneracao::class);
                $repo->incluir_ou_editar($data, $id, $regeneracaoId);

                // alterar para json
                $modelJson = new JsonModel();
                $modelJson->setVariable('regeneracaoId', $regeneracaoId);
                $modelJson->setVariable('success', 1);
                return $modelJson;
            }
        } else {
            if (null != $itemRegeneracao) {
                if($itemRegeneracao->getMaterial()->getBag()->getPesoSem() > 0) {
                    $quantidadeAtual = (100 * $itemRegeneracao->getMaterial()->getBag()->getPesoTotal()) / $itemRegeneracao->getMaterial()->getBag()->getPesoSem();
                } else {
                    $quantidadeAtual = 0;
                }
                $form->get('quantidadeAtual')->setValue(number_format($quantidadeAtual, 2,',','.'));
                $form->setData($itemRegeneracao->toArray());
            }
        }
        $view = new ViewModel([
            'form' => $form,
            'buscarBanco' => $buscarBanco
        ]);
        return $view->setTerminal(true);
    }

    public function saveFileAction() {
        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {
            $regeneracaoId = $this->params()->fromPost('regeneracaoId');
            $file = $this->params()->fromFiles('arquivo');

            $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\Bag\Service\FileUpload::class);
            $dados = $serviceImportacao->uploadMaterialRegeneracao($file);
            $repoItem = $this->entityManager->getRepository(ItemRegeneracao::class);
            $repoItemAcao = $this->entityManager->getRepository(ItemRegeneracaoAcao::class);

            foreach ($dados as $d) {
                $material = $this->entityManager->getRepository(Material::class)->findOneBy(['cgs' => $d['cgs']]);
                if (!$material && isset($d['acesso']) && $d['acesso'] != '') {
                    $material = $this->entityManager->getRepository(Material::class)->findOneBy(['acesso' => $d['acesso']]);
                }
                if ($material) {
                    $d['material'] = $material->getId();
                }
                $acoes = explode(",", $d['acoes']);
                unset($d['acoes']);
                $itemRegeneracao = $repoItem->incluir_ou_editar($d, NULL, $regeneracaoId);
                $repoItemAcao->incluir($itemRegeneracao, $acoes);
            }
        }
        $modelJson = new JsonModel();
        $modelJson->setVariable('success', 1);
        return $modelJson;
    }

    public function deleteModalAction() {
        $id = $this->params()->fromQuery('id');
        if (!empty($id)) {
            $itemRegeneracao = $this->entityManager->find(ItemRegeneracao::class, $id);
            $regeneracaoId = $itemRegeneracao->getRegeneracao()->getId();
        }
        if ($this->getRequest()->isPost()) {
            $repo = $this->entityManager->getRepository(ItemRegeneracao::class);
            $repo->delete($id);
            $modelJson = new \Zend\View\Model\JsonModel();
            $modelJson->setVariable('regeneracaoId', $regeneracaoId);
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
        $view = new ViewModel([
            'itemRegeneracao' => $itemRegeneracao,
        ]);
        return $view->setTerminal(true);
    }
}

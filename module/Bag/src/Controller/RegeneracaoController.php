<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\RegeneracaoForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\Regeneracao;
use Bag\Entity\Caracteristica;
use Bag\Entity\RegeneracaoCaracteristica;
use Zend\View\Model\JsonModel;

class RegeneracaoController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Regeneracao::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);

            return new ViewModel([
                'regeneracoes' => $paginator
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
            $form = new RegeneracaoForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Regeneracao::class);
                    $row = $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('bag/regeneracao', ['action' => 'save', 'id' => $row->getId()]);
                }
            } else {
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Regeneracao::class);
                    $row = $repo->find($id);
                    if ( !empty($row)) {
                        $form->setData($row->toArray());
                        $form->get('motivo')->setValue($row->getMotivos());
                    }
                }
            }
            $caracteristicas = $this->entityManager->getRepository(Caracteristica::class)->getQuery()->getQuery()->getResult();
            
            return new ViewModel([
                'form' => $form,
                'regeneracao' => $row,
                'caracteristicas' => $caracteristicas
            ]);
	}
        
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/regeneracao');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Regeneracao::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/regeneracao');
            }
            $regeneracao = $repo->find($id);

            return new ViewModel([
                'regeneracao' => $regeneracao,
            ]);
	}
        
        public function changestatusAction()
        {
            $id = (int) $this->params()->fromRoute('id', 0);
            $status = (int) $this->params()->fromRoute('status', null);
            if (!$id || $status < 1) {
                return $this->redirect()->toRoute('bag/regeneracao');
            }
            $repo = $this->entityManager->getRepository(Regeneracao::class);
            $repo->altera_status($id, $status);
            return $this->redirect()->toRoute('bag/regeneracao');
            
        }
        
    public function closeModalAction() 
    {
        $id = $this->params()->fromQuery('id');
        if (!empty($id)) {
            $regeneracao = $this->entityManager->find(Regeneracao::class, $id);
        }
        if ($regeneracao && $this->getRequest()->isPost() && $regeneracao->getStatus() == 1 ) {
            foreach($regeneracao->getItens() as $itemRegeneracao) {
                if ( null != $itemRegeneracao->getMaterial() ) {
                    $bag = $itemRegeneracao->getMaterial()->getBag();
                    $quantidadeAtendida = $itemRegeneracao->getQuantidadePlantada();
                    $pesoSem = $bag->getPesoSem();
                    $pesoBaixa = ($pesoSem * $quantidadeAtendida) / 100;
                    $pesoTotalAtualizado = $bag->getPesoTotal() - $pesoBaixa;
                    $bag->setPesoTotal($pesoTotalAtualizado);
                    $this->entityManager->persist($bag);
                }
            }
            $regeneracao->setStatus(2);
            $this->entityManager->persist($regeneracao);
            $this->entityManager->flush();
            $modelJson = new \Zend\View\Model\JsonModel();
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
        $view = new ViewModel([
            'regeneracao' => $regeneracao,
        ]);
        return $view->setTerminal(true);
    }
    
    public function aplicarEstacaAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $this->params()->fromPost('regeneracaoId');
            $regeneracao = $this->entityManager->find(Regeneracao::class, $id);
            if($regeneracao) {
                $estacaInicial = explode("-",  $regeneracao->getEstacaInicial());
                $prefixo = $estacaInicial[0];
                $sequencia = (int) $estacaInicial[1];
                foreach($regeneracao->getItens() as $item) {
                    $estacaAtual = $prefixo."-".str_pad($sequencia, 5, 0, STR_PAD_LEFT);
                    $sequencia += 1;
                    $item->setEstaca($estacaAtual);
                    $this->entityManager->persist($item);
                }
                $this->entityManager->flush();
            }
            $modelJson = new \Zend\View\Model\JsonModel();
            $modelJson->setVariable('success', 1);
            return $modelJson;
        }
    }
    
    public function updateAction()
    {
            $id = $this->params()->fromRoute('id', null);
            $row = null;
            
            //Cria o formulário
            $form = new RegeneracaoForm($this->objectManager);

            if ( !empty($id)){
                $repo = $this->entityManager->getRepository(Regeneracao::class);
                $row = $repo->find($id);
                if ( !empty($row)) {
                    $form->setData($row->toArray());
                    $form->get('motivo')->setValue($row->getMotivos());
                }
            }
            $caracteristicas = $this->entityManager->getRepository(Caracteristica::class)->getQuery()->getQuery()->getResult();
            
            return new ViewModel([
                'form' => $form,
                'regeneracao' => $row,
                'caracteristicas' => $caracteristicas
            ]);
    }
    
    public function incluirCaracteristicaRotinaAction()
    {
        $id = $this->params()->fromPost('regeneracaoId', null);
        $caracteristicasRotina = $this->entityManager->getRepository(Caracteristica::class)->getQuery(['rotina' => '1'])->getQuery()->getResult();
        $repo = $this->entityManager->getRepository(RegeneracaoCaracteristica::class);
        foreach($caracteristicasRotina as $caracteristica) {
            $repo->saveOne($id, $caracteristica->getId());
        }
        $modelJson = new \Zend\View\Model\JsonModel();
        $modelJson->setVariable('success', 1);
        return $modelJson;
    }
    
    public function incluirCaracteristicaPlanilhaAction()
    {
        $id = $this->params()->fromPost('regeneracaoId', null);
        $caracteristicasId = $this->params()->fromPost('caracteristicas', null);
        $caracteristicas = explode(";", $caracteristicasId);
        $repo = $this->entityManager->getRepository(RegeneracaoCaracteristica::class);

        foreach($caracteristicas as $caracteristica) {
            $repo->saveOne($id, $caracteristica);
        }
        $modelJson = new \Zend\View\Model\JsonModel();
        $modelJson->setVariable('success', 1);
        return $modelJson;
    }
    
    public function attachfileAction()
    {
        $modelJson = new JsonModel();

        if ($this->getRequest()->isPost()) {
            $options = '<option value="">--Selecione--</option>';
            $listaCaracteristicas = "";
            $repoCaracteristicas = $this->entityManager->getRepository(Caracteristica::class);
            $file = $this->params()->fromFiles('arquivo');
            $nomeArquivoAux = trim($file['name']);
            $nomeArquivo = str_replace(' ', '_', $nomeArquivoAux);
            $uploadDir = "/home/aplicacoes/bagarquivos/cadernetas/";
            $serviceImportacao = $this->getEvent()->getApplication()->getServiceManager()->get(\Bag\Service\FileUpload::class);
            $serviceImportacao->uploadCaderneta($file, $nomeArquivo, $uploadDir);
            $conteudo = fopen("/home/aplicacoes/bagarquivos/cadernetas/".$nomeArquivo, "r");
            if ($conteudo) {
                $linha = utf8_encode(trim(fgets($conteudo)));
                $cabecalho = explode(";", $linha);
                foreach($cabecalho as $k => $valor) {
                    $valor = str_replace('"','',$valor);
                    $caracteristica = $repoCaracteristicas->findOneBy(['nomeCurto' => $valor]);
                    if ($caracteristica) {
                        $listaCaracteristicas .= $caracteristica->getId(). ";";
                    } else {
                        $options .= '<option value="'.($k).'">'.str_pad($k+1, 3, 0, STR_PAD_LEFT).' - '. $valor.'</option>';
                    }
                }
                $modelJson->setVariable('success', 1);
                $modelJson->setVariable('options', $options);
                $modelJson->setVariable('caracteristicas', $listaCaracteristicas);
            }
            fclose($conteudo);
        }
        return $modelJson;
    }
    
    public function importarAction() 
    {
        //implementar o carregamento dos dados do arquivo para o banco//
        $modelJson = new JsonModel();
        if ($this->getRequest()->isPost()) {
            $repo = $this->entityManager->getRepository(Regeneracao::class);
        
            $id = $this->params()->fromPost('regeneracaoId', null);
            $regeneracao = $repo->find($id);
            if ($regeneracao) {
                $nomeArquivo = $regeneracao->getNomeArquivo();
                $conteudo = fopen("/home/aplicacoes/bagarquivos/cadernetas/".$nomeArquivo, "r");
                if ($conteudo) {
                    $modelJson->setVariable('success', 1);
                }
            }
        }
        return $modelJson;
    }
    
}

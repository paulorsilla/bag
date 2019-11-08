<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\ImportacaoCadernetaForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\ImportacaoCaderneta;
use Bag\Entity\Caracteristica;
use Bag\Entity\Material;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;

class ImportacaoCadernetaController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(ImportacaoCaderneta::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromQuery();
            $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(10);        
            $paginator->setCurrentPageNumber($page);

            return new ViewModel([
                'importacoes' => $paginator,
                'search' => $search
            ]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            $row = null;
            $repo = $this->entityManager->getRepository(ImportacaoCaderneta::class);
            
            //Cria o formulário
            $form = new ImportacaoCadernetaForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
//                    $row = $repo->incluir_ou_editar($data, $id);
                    $repo->importacao($data);
//                    return $this->redirect()->toRoute('bag/importacao-caderneta', ['action' => 'save', 'id' => $row->getId()]);
                    return $this->redirect()->toRoute('bag/importacao-caderneta', ['action' => 'index']);
                } else {
                    print_r($form->getMessages());
                }
            } else {
                if ( !empty($id)) {
                    $row = $repo->find($id);
                    if ( !empty($row)) {
                       $form->setData($row->toArray());
                    }
                }
            }
            return new ViewModel([
                'importacaoCaderneta' => $row,
                'form' => $form
            ]);
	}
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/importacao-caderneta');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(ImportacaoCaderneta::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/importacao-caderneta');
            }
            $importacaoCaderneta = $repo->find($id);

            return new ViewModel([
                'importacaoCaderneta' => $importacaoCaderneta,
            ]);
	}
        
        public function attachfileAction()
        {
            $modelJson = new JsonModel();
            $options = '<option value="">--Selecione--</option>';

            if ($this->getRequest()->isPost()) {
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
                        $options .= '<option value="'.($k).'">'.str_pad($k+1, 3, 0, STR_PAD_LEFT)." - ".str_replace('"', '', $valor).'</option>';
                    }
                    $listaCaracteristicas = "";
                    $repoCaracteristicas = $this->entityManager->getRepository(Caracteristica::class);
                    $caracteristicas = $repoCaracteristicas->findAll();
                    foreach($caracteristicas as $caracteristica) {
                        $listaCaracteristicas .=  $caracteristica->getNomeCurto().";";
                    }
                    $modelJson->setVariable('success', 1);
                    $modelJson->setVariable('options', $options);
                    $modelJson->setVariable('caracteristicas', $listaCaracteristicas);
                }
                fclose($conteudo);
            }
            return $modelJson;
        }
        
        public function preprocessamentoAction()
        {
            $modelJson = new JsonModel();
            
            if ($this->getRequest()->isPost()) {
               
                $repoMaterial = $this->entityManager->getRepository(Material::class);
                $nomeArquivo = $this->params()->fromPost('nomeArquivo');
                $colunaCgs = (int) $this->params()->fromPost('colunaCgs');
                $colunaAcesso = (int) $this->params()->fromPost('colunaAcesso');
                $conteudo = fopen("/home/aplicacoes/bagarquivos/cadernetas/".$nomeArquivo, "r");
                $linha = utf8_encode(trim(fgets($conteudo))); //avança o ponteiro para a segunda linha do arquivo
                
                $naoEncontrados = "<h3>Materiais não encontrados</h3>";
                $contaNaoEncontrado = 0;
                $contaLinha = 1;
                
                while($linha = utf8_encode(fgets($conteudo))) {
                    $contaLinha += 1;
                    $linhaAux = explode(";", $linha);
                    $cgs = str_replace('"','', $linhaAux[$colunaCgs]);
                    $acesso = str_replace('"', '', $linhaAux[$colunaAcesso]);
                    $material = NULL;
                    if($cgs != '') {
                        $material = $repoMaterial->findOneBy(['cgs' => $cgs]);
                    }
                    else if ($acesso != '') {
                        $material = $repoMaterial->findOneBy(['acesso' => $acesso]);
                    } 
                    if (!$material) {
                        $contaNaoEncontrado += 1;
                        $naoEncontrados .= "[".$contaLinha."]";
                        $naoEncontrados .= ($cgs != '') ? " - <b>CGS: ".$cgs."</b>" : "";
                        $naoEncontrados .= ($acesso != '') ? " - <b>Acesso: ".$acesso."</b>" : "";
                        $naoEncontrados .= " - ";
                    }
                }
                $naoEncontrados .= "<h3>Total: ".$contaNaoEncontrado."</h3>";

                fclose($conteudo);
                $modelJson->setVariable('success', 1);
                $modelJson->setVariable('naoEncontrados', $naoEncontrados);
            }
            return $modelJson;
        }
}

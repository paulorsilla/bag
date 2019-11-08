<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\MaterialForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Bag\Entity\Material;
use Bag\Entity\Localizacao;
use Bag\Entity\Caracteristica;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class MaterialController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Material::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromQuery();
            $adapter = new DoctrineAdapter(new ORMPaginator($repo->getQuery($search)));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(10);        
            $paginator->setCurrentPageNumber($page);

            return new ViewModel([
                'materiais' => $paginator,
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
            $repo = $this->entityManager->getRepository(Material::class);
            
            //Cria o formulário
            $form = new MaterialForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $row = $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('bag/material', ['action' => 'save', 'id' => $row->getId()]);
                }
            } else {
                if ( !empty($id)) {
                    $row = $repo->find($id);
                    if ( !empty($row)) {
                       $form->setData($row->toArray());
                    }
                    if ( null != $row->getEspecie() ) {
                        $form->get('genero')->setValue($row->getEspecie()->getGenero()->id);
                    }
                }
            }
            return new ViewModel([
                'material1' => $row,
                'form' => $form
            ]);
	}
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/material');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Material::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/material');
            }
            $material = $repo->find($id);

            return new ViewModel([
                'material' => $material,
            ]);
	}
        
    public function buscaSaldoAction() 
    {
        $id = $this->params()->fromQuery('id');

        if (!empty($id)) {
            $material = $this->entityManager->find(Material::class, $id);
            $quantidadeAtual = 0;
            if ($material->getBag()->getPesoSem() > 0) {
                $quantidadeAtual = (100 * $material->getBag()->getPesoTotal()) / $material->getBag()->getPesoSem();
            }

            // alterar para json
            $modelJson = new JsonModel();
            $modelJson->setVariable('quantidadeAtual', number_format($quantidadeAtual, 2,',','.'));
            $modelJson->setVariable('success', 1);
            return $modelJson;
        } else {
            return false;
        }
    }
    
    public function inconsistenciasAction()
    {
        $repo = $this->entityManager->getRepository(Material::class);
        $materiais = $repo->findall();
        $buscaCgs = [];
        $buscaAcesso = [];
        $buscaLocalizacao = [];
        $resultadosCgs = [];
        $resultadosAcesso = [];
        $resultadosLocalizacao = [];
        foreach($materiais as $material) {
            if (!isset($buscaCgs[$material->getCgs()])) {
                $buscaCgs[$material->getCgs()] = True;
            } else {
                array_push($resultadosCgs, $material);
            }
            $acesso = strtoupper($material->getAcesso());
            
            if (!isset($buscaAcesso[$acesso])) {
                $buscaAcesso[$acesso] = True;
            } else {
                if (!in_array($material->getAcesso(), $resultadosAcesso)) {
                    array_push($resultadosAcesso, $material->getAcesso());
                }
            }
            if (!isset($buscaLocalizacao[$material->getBag()->getLocalizacao()->id])) {
                $buscaLocalizacao[$material->getBag()->getLocalizacao()->id] = True; 
            } else {
                array_push($resultadosLocalizacao, $material->getBag()->getLocalizacao());
            }
        }
        return new ViewModel([
            'resultadosCgs' => $resultadosCgs,
            'resultadosAcesso' => $resultadosAcesso,
            'resultadosLocalizacao' => $resultadosLocalizacao
        ]);
    }
    
    public function cgsdisponiveisAction()
    {
        $repo = $this->entityManager->getRepository(Material::class);
        $repoLocalizacao  = $this->entityManager->getRepository(Localizacao::class);
        $materiais = $repo->findall([], ['cgs' => 'ASC']);
        $cgs = [];
        $resultados = [];
        foreach($materiais as $material) {
            $idCgs = (int) substr($material->getCgs(), 3);
            $cgs[$idCgs] = True;
        }
        
        for($count = 1; $count <= $idCgs; $count++) {
            if (!isset($cgs[$count])) {
                $stringCgs = "CGS".str_pad($count, 5, "0", STR_PAD_LEFT);
                array_push($resultados, $stringCgs);
            }
        }
        
        $localizacoesDisponiveis = $repoLocalizacao->findBy(['status' => FALSE]);
        
        return new ViewModel([
            'resultados' => $resultados,
            'ultimoCgs' => "CGS".str_pad($idCgs, 5, "0", STR_PAD_LEFT),
            'localizacoesDisponiveis' => $localizacoesDisponiveis
        ]);
    }
    
    public function exportarcsvAction()
    {
        $repo = $this->entityManager->getRepository(Material::class);
        $repoCaracteristicas = $this->entityManager->getRepository(Caracteristica::class);
        $materiais = $repo->getQuery([], True);
        $caracteristicas = $repoCaracteristicas->getQuery(['ordem' => '1'])->getQuery()->getResult();

        //cabecalho
        $csvData = "CGS;BRACOD;Acesso;Programa;Origem;Estaca;Instituição;Data de inclusão;Safra;Localização;Tipo de Bag;Sinonimia;Observação;Peso 100;Peso total;Número sementes";
        $indices = [];

        foreach($caracteristicas as $k => $caracteristica) {
            $csvData .= ";".$caracteristica->getNomeCurto();
            $indices[$caracteristica->getId()] = $k;
        }
        $csvData .= "\n";
        
        foreach ($materiais as $material) {
            $descricaoTipoBag = "";
            foreach($material->getTiposBag() as $materialTipoBag) {
                $descricaoTipoBag .= $materialTipoBag->getTipoBag()->getDescricao() . " ";
            }
            $dataInclusao = (null != $material->getBag()->getDataInclusao() ) ?
                    $material->getBag()->getDataInclusao()->format("d/m/Y") : "";
            $programa = (null != $material->getPrograma()) ? $material->getPrograma()->getDescricao() : "";
            $origem = "";
            $estaca = "";
            $instituicao = "";
            $safra = "";
            $localizacao = "";
            
            $sinonimia = "";
            $observacao = $material->getObservacao();
            $peso100 = "";
            $pesoTotal = "";
            $numeroSementes = "";
            
            if (null != $material->getPassaporte()) {
                $origem = $material->getPassaporte()->getOrigem();
                $estaca = $material->getPassaporte()->getEstaca();
                $instituicao = $material->getPassaporte()->getInstituicao();
                $sinonimia = $material->getPassaporte()->getSinonimias();
            }
            if (null != $material->getBag()) {
                $saldo = ($material->getBag()->getPesoSem() > 0) ? $material->getBag()->getPesoTotal() * 100 / $material->getBag()->getPesoSem() : 0;
                $numeroSementes = number_format($saldo, 2, ',', '.');
                
                $safra = $material->getBag()->getSafra();
                $localizacao = $material->getBag()->getLocalizacao()->getLocalizacao();
                $peso100 = number_format($material->getBag()->getPesoSem(), 2, ',', '.');
                $pesoTotal = number_format($material->getBag()->getPesoTotal(), 2, ',', '.');
            }

            $csvData .= $material->getCgs() . ";" 
                . $material->getBracod() . ";"
                . $material->getAcesso() . ";" 
                . $programa . ";" . $origem . ";" . $estaca . ";" 
                . $instituicao . ";" . $dataInclusao . ";" 
                . $safra . ";" . $localizacao . ";"
                . $descricaoTipoBag . ";" . $sinonimia . ";" . $observacao . ";"
                . $peso100 . ";" . $pesoTotal . ";" . $numeroSementes.";";

            $vetorCaracteristicas = [];
            foreach($indices as $indice) {
                $vetorCaracteristicas[$indice] = "";
            }
            foreach($material->getCaracteristicas() as $materialCaracteristica) {
                $vetorCaracteristicas[$indices[$materialCaracteristica->getCaracteristica()->getId()]] = $materialCaracteristica->getValor();
            }
            $csvData .= implode(";", $vetorCaracteristicas)."\n";
        }
        header("Content-Encoding: UTF-8");
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=bag-completo.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-length: " . strlen($csvData) . "\r\n");
        echo utf8_decode($csvData);
        die();
    }
        
}

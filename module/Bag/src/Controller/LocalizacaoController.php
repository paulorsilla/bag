<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bag\Entity\Bag;
use Bag\Entity\Localizacao;
use Bag\Entity\Modulo;

class LocalizacaoController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Localizacao::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);
            return new ViewModel([
                'localizacoes' => $paginator,
            ]);	
	}
        
        public function createAction()
        {
            $repoModulo = $this->entityManager->getRepository(Modulo::class);
            $repo = $this->entityManager->getRepository(Localizacao::class);
            $modulos = $repoModulo->getQuery()->getQuery()->getResult();
            
            foreach($modulos as $modulo) {
                $lados = [];
                switch($modulo->getLados()) {
                    case 2: $lados = ["D"]; break;
                    case 3: $lados = ["E"]; break;
                    default: $lados = ["D", "E"];
                }
                foreach($lados as $lado) {
                    for($face = 1; $face <= $modulo->getFaces(); $face++) {
                        for($nivel = 1; $nivel <= $modulo->getNiveis(); $nivel++) {
                            $nivelAux = str_pad($nivel, 2, '0', STR_PAD_LEFT);
                            for($espaco = 1; $espaco <= $modulo->getEspacos(); $espaco++) {
                                $espacoAux = str_pad($espaco, 2, '0', STR_PAD_LEFT);
                                $localizacao = "M".$modulo->getNumero().".".$lado.".F".$face.".".$nivelAux.".".$espacoAux;
                                $resultado = $repo->findOneBy(['localizacao' => $localizacao]);
                                if (!$resultado) {
                                    $dados = ['modulo' => $modulo, 'localizacao' => $localizacao, 'status' => 0];
                                    $repo->incluir_ou_editar($dados);
                                }
                            }
                        }
                    }
                }
            }
            //$this->entityManager->flush();
            return $this->redirect()->toRoute('bag/localizacao');
        }
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('bag/localizacao');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Localizacao::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $id = (int) $request->getPost('id');
                    $repo->delete($id);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('bag/localizacao');
            }
            $localizacao = $repo->find($id);

            return new ViewModel([
                'localizacao' => $localizacao,
            ]);
	}
        
        public function checagemAction()
        {
            //ajustar o status da localizacao
            $repoBag = $this->entityManager->getRepository(Bag::class);
//          $repo = $this->entityManager->getRepository(Localizacao::class);
//            $localizacoes = $repo->findAll();
            
//            foreach($localizacoes as $localizacao) {
//                $localizacao->setStatus(0);
//                $this->entityManager->persist($localizacao);
//            }
//            unset($localizacoes);

            $bags = $repoBag->findall();
            foreach($bags as $bag) {
                $l = $bag->getLocalizacao();
                $l->setStatus(1);
                $this->entityManager->persist($l);
            }
            $this->entityManager->flush();
            return $this->redirect()->toRoute('bag/localizacao');
        }
}

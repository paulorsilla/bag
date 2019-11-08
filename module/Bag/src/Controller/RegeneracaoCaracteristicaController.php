<?php

namespace Bag\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Bag\Form\RegeneracaoCaracteristicaForm;
use Zend\View\Model\ViewModel;
use Bag\Entity\RegeneracaoCaracteristica;
use Bag\Entity\Regeneracao;
use Zend\View\Model\JsonModel;

class RegeneracaoCaracteristicaController extends AbstractActionController
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
	
        public function gridModalAction()
	{
            $regeneracaoId = $this->params()->fromQuery('id', 0);
            $regeneracao = $this->entityManager->find(Regeneracao::class, $regeneracaoId);
            $view = new ViewModel([
                'regeneracao' => $regeneracao,
            ]);
            return $view->setTerminal(true);
	}
        
	/**
	 * Action para salvar um novo registro
	 */
	public function saveModalAction()
	{
                $idRegeneracao = $this->params()->fromQuery('regeneracaoId');
                
		//Cria o formulário
		$form = new RegeneracaoCaracteristicaForm($this->objectManager);
		
		//Verifica se a requisição utiliza o método POST
		if ($this->getRequest()->isPost()) {
                    
                    //Recebe os dados via POST
                    $data = $this->params()->fromPost();

                    //Preenche o form com os dados recebidos e o valida
                    $form->setData($data);
                    if ($form->isValid()) {
                        $data = $form->getData();
                        $repo = $this->entityManager->getRepository(RegeneracaoCaracteristica::class);
                        $repo->save($data, $idRegeneracao);
                        
                        // alterar para json
                        $modelJson = new JsonModel();
                        $modelJson->setVariable('regeneracaoId', $idRegeneracao);
                        $modelJson->setVariable('success', 1);
                        return $modelJson;
                    }
		}
                $view = new ViewModel([
                    'form' => $form
		]);
		return $view->setTerminal(true);
	}
        
        public function deleteModalAction()
        {
            $idRegeneracao = $this->params()->fromQuery('idRegeneracao');
            $idCaracteristica = $this->params()->fromQuery('idCaracteristica');
            
            $repo = $this->entityManager->getRepository(RegeneracaoCaracteristica::class);
            
            if ($this->getRequest()->isPost()) {
                $idRegeneracao = $this->params()->fromPost('idRegeneracao');
                $idCaracteristica = $this->params()->fromPost('idCaracteristica');
                $repo->delete($idRegeneracao, $idCaracteristica);
                $modelJson = new \Zend\View\Model\JsonModel();
                $modelJson->setVariable('regeneracaoId', $idRegeneracao);
                $modelJson->setVariable('success', 1);
                return $modelJson;
            }
            $regeneracaoCaracteristica = $repo->findOneBy(['regeneracao' => $idRegeneracao, 'caracteristica' => $idCaracteristica]);
            $view = new ViewModel([
                'regeneracaoCaracteristica' => $regeneracaoCaracteristica,
            ]);
            return $view->setTerminal(true);
        }
}

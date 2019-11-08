<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para a importação das cadernetas 
 */
class ImportacaoCadernetaForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('importacao-caracteristica-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');
        $this->objectManager = $objectManager;
        $this->addElements();
        $this->addInputFilter();
    }
    
    public function getObjectManager() {
        return $this->objectManager;
    }

    protected function addElements() {
        //Adiciona o campo "dataImportacao"
        $this->add([
            'type' => 'text',
            'name' => 'dataImportacao',
            'attributes' => [
                'id' => 'dataImportacao',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Data da importação'
            ],
        ]);
        
        //Adiciona o campo "responsavel"
        $this->add([
            'type' => 'text',
            'name' => 'responsavel',
            'attributes' => [
                'id' => 'responsavel',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Responsável'
            ],
        ]);

        //Adiciona o campo "nomeArquivo"
        $this->add([
            'type' => 'text',
            'name' => 'nomeArquivo',
            'attributes' => [
                'id' => 'nomeArquivo',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Nome do arquivo'
            ],
        ]);

        //Adiciona o campo "colunaCgs"
        $this->add([
            'type' => 'select',
            'name' => 'colunaCgs',
            'attributes' => [
                'id' => 'colunaCgs',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'CGS',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaAcesso"
        $this->add([
            'type' => 'select',
            'name' => 'colunaAcesso',
            'attributes' => [
                'id' => 'colunaAcesso',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Acesso',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaLocalizacao"
        $this->add([
            'type' => 'select',
            'name' => 'colunaLocalizacao',
            'attributes' => [
                'id' => 'colunaLocalizacao',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Localização',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaEspecie"
        $this->add([
            'type' => 'select',
            'name' => 'colunaEspecie',
            'attributes' => [
                'id' => 'colunaEspecie',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Espécie',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaLocaPrograma"
        $this->add([
            'type' => 'select',
            'name' => 'colunaPrograma',
            'attributes' => [
                'id' => 'colunaPrograma',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Programa',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaCultivar"
        $this->add([
            'type' => 'select',
            'name' => 'colunaCultivar',
            'attributes' => [
                'id' => 'colunaCultivar',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Cultivar',
                'disable_inarray_validator' => true
            ],
        ]);
        
//        //Adiciona o campo "Caracteristica"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'caracteristica',
//            'attributes' => [
//                'id' => 'caracteristia',
//                'class' => 'form-control',
//            ],
//            'options' => [
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \Bag\Entity\Caracteristica::class,
//                'property' => 'nomeCurto',
//                'display_empty_item' => true,
//            ]
//        ]);
        
        //Adiciona o campo "fileUpload"
        $this->add([
           'type' => 'file',
           'name' => 'fileUpload',
           'attributes' => [
               'id' => 'fileUpload'
           ],
           'options' => [
               'label' => 'Carregar planilha',
           ],
        ]);
        
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'responsavel',
            'required' => false
        ]);
        
        $inputFilter->add([
            'name' => 'dataImportacao',
            'required' => false
        ]);

        $inputFilter->add([
            'name' => 'colunaEspecie',
            'required' => false
        ]);
        
        $inputFilter->add([
            'name' => 'colunaCultivar',
            'required' => false
        ]);
        
        $this->setInputFilter($inputFilter);
    }
}

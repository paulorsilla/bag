<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de especie
 */
class RegeneracaoForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('regeneracao-form');

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
        
        //Adiciona o campo "motivo"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'motivo',
            'attributes' => [
                'id' => 'motivo',
                'class' => 'form-control',
                'multiple' => true,
            ],
            'options' => [
                'label' => 'Motivo',
//                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Motivo::class,
                'property' => 'descricao',
                'display_empty_item' => false,
            ]
        ]);
        
        //Adiciona o campo "titulo"
        $this->add([
            'type' => 'text',
            'name' => 'titulo',
            'attributes' => [
                'id' => 'titulo'
            ],
            'options' => [
                'label' => 'Título'
            ],
        ]);
        
        //Adiciona o campo "safra"
        $this->add([
            'type' => 'text',
            'name' => 'safra',
            'attributes' => [
                'id' => 'safra'
            ],
            'options' => [
                'label' => 'Safra'
            ],
        ]);
                
        //Adiciona o campo "diasLuz"
        $this->add([
            'type' => 'text',
            'name' => 'diasLuz',
            'attributes' => [
                'id' => 'diasLuz'
            ],
            'options' => [
                'label' => 'Dias luz'
            ],
        ]);

        //Adiciona o campo "casaVegetacao"
        $this->add([
            'type' => 'text',
            'name' => 'casaVegetacao',
            'attributes' => [
                'id' => 'casaVegetacao'
            ],
            'options' => [
                'label' => 'Casa de vegetação'
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
        
        //Adiciona o campo "colunaSinonimia1"
        $this->add([
            'type' => 'select',
            'name' => 'colunaSinonimia',
            'attributes' => [
                'id' => 'colunaSinonimia',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Sinonimia',
                'disable_inarray_validator' => true
            ],
        ]);
        
        //Adiciona o campo "colunaSinonimia2"
        $this->add([
            'type' => 'select',
            'name' => 'colunaSinonimia II',
            'attributes' => [
                'id' => 'colunaSinonimia II',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Sinonimia II',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaSinonimia3"
        $this->add([
            'type' => 'select',
            'name' => 'colunaSinonimia III',
            'attributes' => [
                'id' => 'colunaSinonimia III',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Sinonimia III',
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
        
        //Adiciona o campo "colunaOrigem"
        $this->add([
            'type' => 'select',
            'name' => 'colunaOrigem',
            'attributes' => [
                'id' => 'colunaOrigem',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Origem',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaEstaca"
        $this->add([
            'type' => 'select',
            'name' => 'colunaEstaca',
            'attributes' => [
                'id' => 'colunaEstaca',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Estaca',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaQuantidade"
        $this->add([
            'type' => 'select',
            'name' => 'colunaDataPlantio',
            'attributes' => [
                'id' => 'colunaDataPlantio',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Data do plantio',
                'disable_inarray_validator' => true
            ],
        ]);
        
        //Adiciona o campo "colunaQuantidade"
        $this->add([
            'type' => 'select',
            'name' => 'colunaQuantidade',
            'attributes' => [
                'id' => 'colunaQuantidade',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Quantidade plantada',
                'disable_inarray_validator' => true
            ],
        ]);

        //Adiciona o campo "colunaAcoes"
        $this->add([
            'type' => 'select',
            'name' => 'colunaAcoes',
            'attributes' => [
                'id' => 'colunaAcoes',
                'class' => 'form-control',
        ],
            'options' => [
                'label' => 'Ações',
                'disable_inarray_validator' => true
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
        
        //Adiciona o campo "fileUpload"
        $this->add([
           'type' => 'file',
           'name' => 'fileUpload',
           'attributes' => [
               'id' => 'fileUpload'
           ],
           'options' => [
               'label' => 'Carregar',
           ],
        ]);        
        
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id' => 'submitbutton',
            ]
        ]);
    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'titulo',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 2,
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'motivo',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'safra',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 2,
                        'max' => 4
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'colunaCgs',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'colunaAcesso',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'colunaLocalizacao',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'colunaSinonimia',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'colunaSinonimia II',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'colunaSinonimia III',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'colunaOrigem',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'colunaEstaca',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'colunaDataPlantio',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'colunaQuantidade',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'colunaAcoes',
            'required' => false,
        ]);
    }
}

<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de estado
 */
class InstituicaoForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('instituicao-form');

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
        
        //Adiciona o campo "razaoSocial"
        $this->add([
            'type' => 'text',
            'name' => 'razaoSocial',
            'attributes' => [
                'id' => 'razaoSocial',
                'placeholder' => 'Digite a razão social aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Razão Social'
            ],
        ]);

        //Adiciona o campo "nomeFantasia"
        $this->add([
            'type' => 'text',
            'name' => 'nomeFantasia',
            'attributes' => [
                'id' => 'nomeFantasia',
                'placeholder' => 'Digite o nome fantasia aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Nome Fantasia'
            ],
        ]);

        //Adiciona o campo "endereço"
        $this->add([
            'type' => 'text',
            'name' => 'endereco',
            'attributes' => [
                'id' => 'endereco',
                'placeholder' => 'Digite o endereço aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Endereço'
            ],
        ]);
        
        //Adiciona o campo "bairro"
        $this->add([
            'type' => 'text',
            'name' => 'bairro',
            'attributes' => [
                'id' => 'bairro',
                'placeholder' => 'Digite o bairro aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Bairro'
            ],
        ]);

        //Adiciona o campo "caixaPostal"
        $this->add([
            'type' => 'text',
            'name' => 'caixaPostal',
            'attributes' => [
                'id' => 'caixaPostal',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Caixa Postal'
            ],
        ]);

        //Adiciona o campo "cep"
        $this->add([
            'type' => 'text',
            'name' => 'cep',
            'attributes' => [
                'id' => 'cep',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'CEP'
            ],
        ]);
        
        //Adiciona o campo "pais"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'pais',
            'attributes' => [
                'id' => 'pais',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'País',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Pais::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);  
        
        //Adiciona o campo "cidade"
        $this->add([
            'type' => 'text',
            'name' => 'cidade',
            'attributes' => [
                'id' => 'cidade',
                'placeholder' => 'Digite a cidade aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Cidade'
            ],
        ]);

        //Adiciona o campo "uf"
        $this->add([
            'type' => 'select',
            'name' => 'uf',
            'attributes' => [
                'id' => 'uf',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'UF',
                'disable_inarray_validator' => true,
            ],
        ]);
        
        //Adiciona o campo "telefone"
        $this->add([
            'type' => 'text',
            'name' => 'telefone',
            'attributes' => [
                'id' => 'telefone',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Telefone'
            ],
        ]);

        //Adiciona o campo "telefone2"
        $this->add([
            'type' => 'text',
            'name' => 'telefone2',
            'attributes' => [
                'id' => 'telefone2',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Telefone Celular'
            ],
        ]);

        //Adiciona o campo "telefone3"
        $this->add([
            'type' => 'text',
            'name' => 'telefone3',
            'attributes' => [
                'id' => 'telefone3',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Fax/WhatsApp'
            ],
        ]);
        
        //Adiciona o campo "cnpj"
        $this->add([
            'type' => 'text',
            'name' => 'cnpj',
            'attributes' => [
                'id' => 'cnpj',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'CNPJ/CPF'
            ],
        ]);

        //Adiciona o campo "inscricaoEstadual"
        $this->add([
            'type' => 'text',
            'name' => 'inscricaoEstadual',
            'attributes' => [
                'id' => 'inscricaoEstadual',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Inscricao Estadual/RG'
            ],
        ]);

        //Adiciona o campo "homePage"
        $this->add([
            'type' => 'text',
            'name' => 'homePage',
            'attributes' => [
                'id' => 'homePage',
                'placeholder' => 'Digite a homepage aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Home Page'
            ],
        ]);

        //Adiciona o campo "email"
        $this->add([
            'type' => 'text',
            'name' => 'email',
            'attributes' => [
                'id' => 'email',
                'placeholder' => 'Digite o e-mail aqui',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'E-mail'
            ],
        ]);
        
        //Adiciona o campo "tipoPessoa"
        $this->add([
            'type' => 'select',
            'name' => 'tipoPessoa',
            'attributes' => [
                'id' => 'tipoPessoa',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Tipo',
                'value_options' => [
                    "1" => "Pessoa Jurídica",
                    "2" => "Pessoa Física",
                ]
            ]
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
            'name' => 'razaoSocial',
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
                        'min' => 3,
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'nomeFantasia',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 225
                    ],
                ],
            ],
        ]);
        
        
        $inputFilter->add([
            'name' => 'cnpj',
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
                        'min' => 1,
                        'max' => 20
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'uf',
            'required' => false,
        ]);
        
    }
}

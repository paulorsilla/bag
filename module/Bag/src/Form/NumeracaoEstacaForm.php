<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de característica
 */
class NumeracaoEstacaForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('numeracao-estaca-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'ano',
            'attributes' => [
                'id' => 'ano'
            ],
            'options' => [
                'label' => 'Ano'
            ],
        ]);
        
        //Adiciona o campo "sequencia"
        $this->add([
            'type' => 'text',
            'name' => 'sequencia',
            'attributes' => [
                'id' => 'sequencia'
            ],
            'options' => [
                'label' => 'Sequência'
            ],
        ]);
        
        //Adiciona o campo "prefixo"
        $this->add([
            'type' => 'text',
            'name' => 'prefixo',
            'attributes' => [
                'id' => 'prefixo'
            ],
            'options' => [
                'label' => 'Prefixo'
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
            'name' => 'ano',
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
            'name' => 'prefixo',
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
                        'min' => 0,
                        'max' => 25
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'sequencia',
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
                        'min' => 0,
                        'max' => 25
                    ],
                ],
            ],
        ]);
    }
}

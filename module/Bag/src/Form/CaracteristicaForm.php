<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de característica
 */
class CaracteristicaForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('caracteristica-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao'
            ],
            'options' => [
                'label' => 'Descrição'
            ],
        ]);
        
        //Adiciona o campo "nomeCurto"
        $this->add([
            'type' => 'text',
            'name' => 'nomeCurto',
            'attributes' => [
                'id' => 'nomeCurto'
            ],
            'options' => [
                'label' => 'Nome curto'
            ],
        ]);
        
        //Adiciona o campo "ordem"
        $this->add([
            'type' => 'text',
            'name' => 'ordem',
            'attributes' => [
                'id' => 'ordem'
            ],
            'options' => [
                'label' => 'Ordem'
            ],
        ]);

        //Adiciona o campo "rotina"
        $this->add([
            'type' => 'select',
            'name' => 'rotina',
            'attributes' => [
                'id' => 'rotina',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Rotina',
                'value_options' => [
                    "0" => "Não",
                    "1" => "Sim"
                ]
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
            'name' => 'descricao',
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
                        'min' => 2,
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'nomeCurto',
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
                        'max' => 30
                    ],
                ],
            ],
        ]);

        
    }

}

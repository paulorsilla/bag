<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de módulo
 */
class ModuloForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('modulo-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "numero"
        $this->add([
            'type' => 'text',
            'name' => 'numero',
            'attributes' => [
                'id' => 'numero',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Número do módulo'
            ],
        ]);
        
        //Adiciona o campo "lados"
        $this->add([
            'type' => 'select',
            'name' => 'lados',
            'attributes' => [
                'id' => 'lados',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Lados',
                'value_options' => [
                    "1" => "Direito e esquerdo",
                    "2" => "Direito",
                    "3" => "Esquerdo",
                ]
            ],
        ]);

        //Adiciona o campo "faces"
        $this->add([
            'type' => 'text',
            'name' => 'faces',
            'attributes' => [
                'id' => 'faces',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Número de faces'
            ],
        ]);

        //Adiciona o campo "niveis"
        $this->add([
            'type' => 'text',
            'name' => 'niveis',
            'attributes' => [
                'id' => 'niveis',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Número de níveis'
            ],
        ]);

        //Adiciona o campo "espacos"
        $this->add([
            'type' => 'text',
            'name' => 'espacos',
            'attributes' => [
                'id' => 'espacos',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Número de posições'
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
            'name' => 'numero',
            'required' => true,
        ]);
        $inputFilter->add([
            'name' => 'lados',
            'required' => true,
        ]);
        $inputFilter->add([
            'name' => 'faces',
            'required' => true,
        ]);
        $inputFilter->add([
            'name' => 'niveis',
            'required' => true,
        ]);
        $inputFilter->add([
            'name' => 'espacos',
            'required' => true,
        ]);
    }
}

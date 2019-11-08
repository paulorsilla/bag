<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de especie
 */
class EspecieForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('especie-form');

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
        
        //Adiciona o campo "genero"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'genero',
            'attributes' => [
                'id' => 'genero',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Gênero',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Genero::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);        
        
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

        //Adiciona o campo "quantidadeMinima"
        $this->add([
            'type' => 'text',
            'name' => 'quantidadeMinima',
            'attributes' => [
                'id' => 'quantidadeMinima'
            ],
            'options' => [
                'label' => 'Quantidade Mínima'
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
            'name' => 'genero',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'quantidadeMinima',
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
                        'max' => 11
                    ],
                ],
            ],
        ]);
        
    }
}

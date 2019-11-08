<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de estado
 */
class EstadoForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('estado-form');

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
        
        //Adiciona o campo "descricao"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao'
            ],
            'options' => [
                'label' => 'Estado'
            ],
        ]);

        //Adiciona o campo "sigla"
        $this->add([
            'type' => 'text',
            'name' => 'sigla',
            'attributes' => [
                'id' => 'sigla'
            ],
            'options' => [
                'label' => 'Sigla'
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
            'name' => 'sigla',
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
                        'max' => 10
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'pais',
            'required' => true,
        ]);
        
    }
}

<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de passaporte
 */
class MaterialCaracteristicaForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('material-caracteristica-form');

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
        
        //Adiciona o campo "valor"
        $this->add([
            'type' => 'text',
            'name' => 'valor',
            'attributes' => [
                'id' => 'valor',
                'class' => 'form-control',
                'place-holder' => 'Digite o valor aqui'
            ],
            'options' => [
                'label' => 'Valor'
            ],
        ]);
        
        //Adiciona o campo "caracteristica"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'caracteristica',
            'attributes' => [
                'id' => 'caracteristica',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Característica',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Caracteristica::class,
                'property' => 'nomeCurto',
                'display_empty_item' => true,
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
            'name' => 'valor',
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
                        'max' => 50
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'caracteristica',
            'required' => true,
        ]);
    }
}

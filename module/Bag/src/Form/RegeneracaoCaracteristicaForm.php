<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o vínculo de características à regeneração
 */
class RegeneracaoCaracteristicaForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('regeneracao-caracteristica-form');

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
        
        //Adiciona o campo "caracteristica"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'caracteristica',
            'attributes' => [
                'id' => 'caracteristica',
                'class' => 'form-control',
                'multiple' => true,
            ],
            'options' => [
                'label' => 'Característica',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Caracteristica::class,
                'property' => 'nomeCurto',
                'display_empty_item' => false,
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
            'name' => 'caracteristica',
            'required' => true,
        ]);
    }
}

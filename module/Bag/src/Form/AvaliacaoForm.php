<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de avaliação
 */
class AvaliacaoForm extends Form {
    
    protected $objectManager;

    protected $idRegeneracao;

    /**
     * Construtor
     */
    public function __construct($objectManager, $idRegeneracao) {
        //Determina o nome do formulário
        parent::__construct('avaliacao-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');
        
        $this->objectManager = $objectManager;
        $this->idRegeneracao = $idRegeneracao;

        $this->addElements();
        $this->addInputFilter();
    }
    
    public function getObjectManager() {
        return $this->objectManager;
    }
    
    public function getIdRegeneracao() {
        return $this->idRegeneracao;
    }

    protected function addElements() {
        
        
        //Adiciona o campo "substituicoes"
        $this->add([
            'type' => 'text',
            'name' => 'substituicoes',
            'attributes' => [
                'id' => 'substituicoes',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Substituições'
            ],
        ]);

        //Adiciona o campo "data_retirada"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataAvaliacao',
            'attributes' => [
                'id' => 'dataAvaliacao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data da avaliação'
            ],
        ]);
        
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'responsavel',
            'attributes' => [
                'id' => 'responsavel',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Responsável pela avaliação',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \User\Entity\User::class,
                'property' => 'nome',
                'display_empty_item' => true,
            ]
        ]);
        
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'caracteristicas',
            'attributes' => [
                'id' => 'caracteristicas',
                'class' => 'form-control',
                'multiple' => true
            ],
            'options' => [
                'label' => 'Descritores avaliados',
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
            'name' => 'dataAvaliacao',
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
                        'min' => 10,
                        'max' => 10
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'responsavel',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'caracteristicas',
            'required' => true,
        ]);
        
        $inputFilter->add([
            'name' => 'substituicoes',
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
    }
}

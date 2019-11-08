<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de pais
 */
class BagForm extends Form {


    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('bag-form');

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
        //Adiciona o campo "safra"
        $this->add([
            'type' => 'text',
            'name' => 'safra',
            'attributes' => [
                'id' => 'safra',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Safra'
            ],
        ]);
        
        //Adiciona o campo "pesoSem"
        $this->add([
            'type' => 'text',
            'name' => 'pesoSem',
            'attributes' => [
                'id' => 'pesoSem',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Peso 100 (g)'
            ],
        ]);

        //Adiciona o campo "peso"
        $this->add([
            'type' => 'text',
            'name' => 'peso',
            'attributes' => [
                'id' => 'peso',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Peso (g)'
            ],
        ]);

        //Adiciona o campo "pesoSem"
        $this->add([
            'type' => 'text',
            'name' => 'multiplicador',
            'attributes' => [
                'id' => 'multiplicador',
                'class' => 'form-control',
                'value' => '4'
            ],
            'options' => [
                'label' => 'Mult. peso'
            ],
        ]);

        //Adiciona o campo "pesoTotal"
        $this->add([
            'type' => 'text',
            'name' => 'pesoTotal',
            'attributes' => [
                'id' => 'pesoTotal',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Peso Total (g)'
            ],
        ]);

        //Adiciona o campo "saldo"
        $this->add([
            'type' => 'text',
            'name' => 'saldo',
            'attributes' => [
                'id' => 'saldo',
                'class' => 'form-control',
                'readonly' => 'readonly'
            ],
            'options' => [
                'label' => 'Nº sementes'
            ],
        ]);
        
//        //Adiciona o campo "localizacao"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'localizacao',
//            'attributes' => [
//                'id' => 'localizacao',
//                'class' => 'form-control',
//            ],
//            'options' => [
//                'label' => 'Localizacao',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \Bag\Entity\Localizacao::class,
//                'property' => 'localizacao',
//                'display_empty_item' => true,
//            ]
//        ]);        
//        
        
        //Adiciona o campo "modulo"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'modulo',
            'attributes' => [
                'id' => 'modulo',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Módulo',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Modulo::class,
                'property' => 'numero',
                'display_empty_item' => true,
            ]
        ]);     
        
        //Adiciona o campo "lado"
        $this->add([
            'type' => 'select',
            'name' => 'lado',
            'attributes' => [
                'id' => 'lado',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Lado',
                'value_options' => [
                ]
            ],
        ]);

        //Adiciona o campo "face"
        $this->add([
            'type' => 'select',
            'name' => 'face',
            'attributes' => [
                'id' => 'face',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Face',
                'value_options' => [
                ]
            ],
        ]);

        //Adiciona o campo "nivel"
        $this->add([
            'type' => 'select',
            'name' => 'nivel',
            'attributes' => [
                'id' => 'nivel',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Nível',
                'value_options' => [
                ]
            ],
        ]);

        //Adiciona o campo "espaco"
        $this->add([
            'type' => 'select',
            'name' => 'espaco',
            'attributes' => [
                'id' => 'espaco',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Posição',
                'value_options' => [
                ]
            ],
        ]);
        
        //Adiciona o campo "localizacao"
        $this->add([
            'type' => 'text',
            'name' => 'localizacao',
            'attributes' => [
                'id' => 'localizacao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Localização'
            ],
        ]);
        
        //Adiciona o campo "dataInclusao"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataInclusao',
            'attributes' => [
                'id' => 'dataInclusao',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data inclusão'
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
                        'min' => 4,
                        'max' => 4
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'pesoSem',
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
                        'max' => 20
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'pesoTotal',
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
                        'max' => 20
                    ],
                ],
            ],
        ]);        
        
        $inputFilter->add([
            'name' => 'saldo',
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
                        'max' => 20
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'localizacao',
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
                        'max' => 20
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'dataInclusao',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'modulo',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'lado',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'face',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'nivel',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'espaco',
            'required' => false,
        ]);
        
    }

}

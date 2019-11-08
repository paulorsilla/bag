<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de passaporte
 */
class PassaporteForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('passaporte-form');

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
        
        //Adiciona o campo "sinonimia1"
        $this->add([
            'type' => 'text',
            'name' => 'sinonimia1',
            'attributes' => [
                'id' => 'sinonimia1',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Sinonimia I'
            ],
        ]);

        //Adiciona o campo "sinonimia2"
        $this->add([
            'type' => 'text',
            'name' => 'sinonimia2',
            'attributes' => [
                'id' => 'sinonimia2',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Sinonimia II'
            ],
        ]);

        //Adiciona o campo "sinonimia3"
        $this->add([
            'type' => 'text',
            'name' => 'sinonimia3',
            'attributes' => [
                'id' => 'sinonimia3',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Sinonimia III'
            ],
        ]);
        
        //Adiciona o campo "sinonimia4"
        $this->add([
            'type' => 'text',
            'name' => 'sinonimia4',
            'attributes' => [
                'id' => 'sinonimia4',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Sinonimia IV'
            ],
        ]);

        //Adiciona o campo "sinonimia5"
        $this->add([
            'type' => 'text',
            'name' => 'sinonimia5',
            'attributes' => [
                'id' => 'sinonimia5',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Sinonimia V'
            ],
        ]);
        
        //Adiciona o campo "origem"
        $this->add([
            'type' => 'text',
            'name' => 'origem',
            'attributes' => [
                'id' => 'origem',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Origem'
            ],
        ]);

        //Adiciona o campo "genealogia"
        $this->add([
            'type' => 'text',
            'name' => 'genealogia',
            'attributes' => [
                'id' => 'genealogia',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Genealogia'
            ],
        ]);

        //Adiciona o campo "genealogiaDescritiva"
        $this->add([
            'type' => 'text',
            'name' => 'genealogiaDescritiva',
            'attributes' => [
                'id' => 'genealogiaDescritiva',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Genealogia descritiva'
            ],
        ]);

        //Adiciona o campo "informacao"
        $this->add([
            'type' => 'text',
            'name' => 'informacao',
            'attributes' => [
                'id' => 'informacao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Informação'
            ],
        ]);

        //Adiciona o campo "instituição"
        $this->add([
            'type' => 'text',
            'name' => 'instituicao',
            'attributes' => [
                'id' => 'instituicao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Instituição'
            ],
        ]);
        
        //Adiciona o campo "estaca"
        $this->add([
            'type' => 'text',
            'name' => 'estaca',
            'attributes' => [
                'id' => 'estaca',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Estaca'
            ],
        ]);
        
//        //Adiciona o campo "instituicao"
//        $this->add([
//            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'instituicao',
//            'attributes' => [
//                'id' => 'instituicao',
//                'class' => 'form-control',
//            ],
//            'options' => [
//                'label' => 'Instituição',
//                'empty_option' => 'Selecione',
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => \Bag\Entity\Instituicao::class,
//                'property' => 'razaoSocial',
//                'find_method' => [
//                    'name' => 'getQuery',
//                    'params' => [
//                        'search' => [
//                            'combo' => 2
//                        ]
//                    ]
//                ],
//            ]
//        ]);
        
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
        
        //Adiciona o campo "estado"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'estado',
            'attributes' => [
                'id' => 'estado',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Estado',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Estado::class,
                'property' => 'descricao',
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
            'name' => 'origem',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'genealogia',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'genealogiaDescritiva',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'sinonimia1',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'sinonimia2',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'sinonimia3',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'sinonimia4',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'sinonimia5',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'informacao',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'instituicao',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'pais',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'estado',
            'required' => false,
        ]);
    }
}

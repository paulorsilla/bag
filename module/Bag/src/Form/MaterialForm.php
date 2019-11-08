<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de passaporte
 */
class MaterialForm extends Form {

    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager) {
        //Determina o nome do formulário
        parent::__construct('material-form');

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
        //Adiciona o campo "cgs"
        $this->add([
            'type' => 'text',
            'name' => 'cgs',
            'attributes' => [
                'id' => 'cgs',
                'class' => 'form-control',
                'placeholder' => 'Digite o CGS aqui'
        ],
            'options' => [
                'label' => 'CGS'
            ],
        ]);

        //Adiciona o campo "bracod"
        $this->add([
            'type' => 'text',
            'name' => 'bracod',
            'attributes' => [
                'id' => 'bracod',
                'class' => 'form-control',
                'placeholder' => 'Digite o BRACOD aqui'
        ],
            'options' => [
                'label' => 'BRACOD'
            ],
        ]);
        
        //Adiciona o campo "acesso"
        $this->add([
            'type' => 'text',
            'name' => 'acesso',
            'attributes' => [
                'id' => 'acesso',
                'class' => 'form-control',
                'placeholder' => 'Digite o Acesso aqui'
            ],
            'options' => [
                'label' => 'Acesso'
            ],
        ]);

        //Adiciona o campo "cultivar"
        $this->add([
            'type' => 'text',
            'name' => 'cultivar',
            'attributes' => [
                'id' => 'cultivar',
                'class' => 'form-control',
                'placeholder' => 'C/N'
            ],
            'options' => [
                'label' => 'Cultivar'
            ],
        ]);

//        //Adiciona o campo "peso"
//        $this->add([
//            'type' => 'text',
//            'name' => 'peso',
//            'attributes' => [
//                'id' => 'peso',
//                'class' => 'form-control',
//                'placeholder' => 'Digite o Peso aqui'
//
//            ],
//            'options' => [
//                'label' => 'Peso'
//            ],
//        ]);
        
        //Adiciona o campo "observacao"
        $this->add([
            'type' => 'textarea',
            'name' => 'observacao',
            'attributes' => [
                'id' => 'observacao',
                'class' => 'form-control',
                'rows' => '2',
                'placeholder' => 'Digite as Observações aqui'
            ],
            'options' => [
                'label' => 'Observação'
            ],
        ]);

        //Adiciona o campo "Gênero"
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
        
        //Adiciona o campo "especie"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'especie',
            'attributes' => [
                'id' => 'especie',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Subcollection',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Especie::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        //Adiciona o campo "Programa"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'programa',
            'attributes' => [
                'id' => 'programa',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Programa',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Programa::class,
                'property' => 'descricao',
                'display_empty_item' => true,
            ]
        ]);
        
        $this->add([
           'type' => 'file',
           'name' => 'file',
           'attributes' => [
               'id' => 'file'
           ],
           'options' => [
               'label' => 'Imagem',
           ],
        ]);
        
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'cgs',
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
                        'min' => 5,
                        'max' => 30
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'bracod',
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
                        'max' => 30
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'acesso',
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
                        'max' => 255
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'cultivar',
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
                        'max' => 1
                    ],
                ],
            ],
        ]);

//        $inputFilter->add([
//            'name' => 'peso',
//            'required' => false,
//            'filters' => [
//                ['name' => 'StringTrim'],
//                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
//            ],
//            'validators' => [
//                [
//                    'name' => 'StringLength',
//                    'options' => [
//                        'min' => 0,
//                        'max' => 20
//                    ],
//                ],
//            ],
//        ]);
        
        $inputFilter->add([
            'name' => 'observacao',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
        ]);

        $inputFilter->add([
            'name' => 'programa',
            'required' => false,
        ]);
        
        $inputFilter->add([
            'name' => 'genero',
            'required' => false,
        ]);

        
        $inputFilter->add([
            'name' => 'especie',
            'required' => true,
        ]);
        
    }
}

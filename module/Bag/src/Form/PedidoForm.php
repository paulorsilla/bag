<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de pais
 */
class PedidoForm extends Form {

    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct($objectManager) {

        //Determina o nome do formulário
        parent::__construct('pedido-form');

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
//        //Adiciona o campo "instituicao"
//        $this->add([
//            'type' => 'text',
//            'name' => 'instituicao',
//            'attributes' => [
//                'id' => 'instituicao',
//                'class' => 'form-control',
//            ],
//            'options' => [
//                'label' => 'Instituição'
//            ],
//        ]);
        
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'instituicao',
            'attributes' => [
                'id' => 'instituicao',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Instituição',
                'empty_option' => 'Selecione',
                'object_manager' => $this->getObjectManager(),
                'target_class' => \Bag\Entity\Instituicao::class,
                'property' => 'razaoSocial',
                'find_method' => [
                    'name' => 'getQuery',
                    'params' => [
                        'search' => [
                            'combo' => 2
                        ]
                    ]
                ],
            ]
        ]);        

        //Adiciona o campo "requisitante"
        $this->add([
            'type' => 'text',
            'name' => 'requisitante',
            'attributes' => [
                'id' => 'requisitante',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Requisitante'
            ],
        ]);

        //Adiciona o campo "recebedor"
        $this->add([
            'type' => 'text',
            'name' => 'recebedor',
            'attributes' => [
                'id' => 'recebedor',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Recebedor'
            ],
        ]);

        //Adiciona o campo "data_retirada"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataRetirada',
            'attributes' => [
                'id' => 'dataRetirada',
                'class' => 'form-control',
            ],
            'options' => [
                'format' => 'Y-m-d',
                'label' => 'Data retirada'
            ],
        ]);

        //Adiciona o campo "tipo"
        $this->add([
            'type' => 'select',
            'name' => 'tipo',
            'attributes' => [
                'id' => 'tipo',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Destino do material',
                'value_options' => [
                    "0" => "Selecione",
                    "1" => "Embrapa",
                    "2" => "Fora da Embrapa",
                    "3" => "Exterior"
                ]
            ],
        ]);

        //Adiciona o campo "anexoAtm"
        $this->add([
            'type' => 'text',
            'name' => 'anexoAtm',
            'attributes' => [
                'id' => 'anexoAtm',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Anexo ATM'
            ],
        ]);

        //Adiciona o campo "area"
        $this->add([
            'type' => 'text',
            'name' => 'area',
            'attributes' => [
                'id' => 'area',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Area'
            ],
        ]);

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
        
        //Adiciona o campo "anexoAtm"
        $this->add([
            'type' => 'text',
            'name' => 'anexoAtm',
            'attributes' => [
                'id' => 'anexoAtm',
                'class' => 'form-control',
                'readonly' => true
            ],
            'options' => [
                'label' => 'ATM'
            ],
        ]);
        
        //Adiciona o campo "fileAtm"
        $this->add([
            'type' => 'Zend\Form\Element\File',
            'name' => 'fileAtm',
            'attributes' => [
                'id' => 'fileAtm',
//                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Anexar ATM'
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
            'name' => 'instituicao',
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
            'name' => 'requisitante',
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
            'name' => 'observacao',
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
                        'max' => 1024
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'dataRetirada',
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
                        'max' => 10
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'anexoAtm',
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
            'name' => 'area',
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
            'name' => 'recebedor',
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
    }

}

<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de passaporte
 */
class ItemRegeneracaoForm extends Form {

    protected $pesquisaCgs;
    protected $pesquisaAcesso;
    protected $pesquisaSinonimia;
    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager, $pesquisaCgs, $pesquisaAcesso, $pesquisaSinonimia) {
        //Determina o nome do formulário
        parent::__construct('item-regeneracao-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');
        $this->objectManager = $objectManager;
        $this->pesquisaCgs = $pesquisaCgs;
        $this->pesquisaAcesso = $pesquisaAcesso;
        $this->pesquisaSinonimia = $pesquisaSinonimia;
        $this->addElements();
        $this->addInputFilter();
    }
    
    public function getObjectManager() {
        return $this->objectManager;
    }

    protected function addElements() {
        
        //Adiciona o campo "recipiente"
        $this->add([
            'type' => 'select',
            'name' => 'recipiente',
            'attributes' => [
                'id' => 'recipiente',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Recipiente',
                'value_options' => [
                    "" => "Selecione",
                    "6" => "Vaso",
                    "3" => "Tubete",
                ]
            ],
        ]);

        //Adiciona o campo "quantidadePlantada"
        $this->add([
            'type' => 'text',
            'name' => 'quantidadePlantada',
            'attributes' => [
                'id' => 'quantidadePlantada',
                'class' => 'form-control',
                'place-holder' => 'Digite a quantidade plantada aqui',
            ],
            'options' => [
                'label' => 'Quantidade plantada'
            ],
        ]);
        
        //Adiciona o campo "quantidadeSolicitada"
        $this->add([
            'type' => 'text',
            'name' => 'quantidadeAtual',
            'attributes' => [
                'id' => 'quantidadeAtual',
                'class' => 'form-control',
                'readonly' => true
            ],
            'options' => [
                'label' => 'Quantidade atual'
            ],
        ]);
        
        //Adiciona o campo "origem"
        $this->add([
            'type' => 'text',
            'name' => 'origem',
            'attributes' => [
                'id' => 'origem',
                'class' => 'form-control',
                'place-holder' => 'Digite a origem aqui',
            ],
            'options' => [
                'label' => 'Origem'
            ],
        ]);
        
        //Adiciona o campo "estaca"
        $this->add([
            'type' => 'text',
            'name' => 'estaca',
            'attributes' => [
                'id' => 'estaca',
                'class' => 'form-control',
                'place-holder' => 'Digite a estaca aqui'
            ],
            'options' => [
                'label' => 'Estaca'
            ],
        ]);

        //Adiciona o campo "material"
        if ($this->pesquisaCgs != "" || $this->pesquisaAcesso != "" || $this->pesquisaSinonimia != "") {
            $this->add([
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'material',
                'attributes' => [
                    'id' => 'material',
                    'class' => 'form-control',
                ],
                'options' => [
                    'label' => 'Material',
                    'object_manager' => $this->getObjectManager(),
                    'target_class'   => \Bag\Entity\Material::class,
                    'display_empty_item' => true,
                    'property'       => 'cgsAcesso',
                    'is_method'      => true,
                    'find_method'    => [
                        'name'   => 'getQuery',
                        'params' => [
                            'search' => ['cgs' => $this->pesquisaCgs, 'acesso' => $this->pesquisaAcesso, 'sinonimia' => $this->pesquisaSinonimia],
                            'combo' => true
                        ],
                    ],
                ],
            ]); 
        }
        
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'acao',
            'attributes' => [
                'id' => 'acao',
                'class' => 'form-control',
                'multiple' => 'multiple'
            ],
            'options' => [
                'label' => 'Ações',
                'object_manager' => $this->getObjectManager(),
                'target_class'   => \Bag\Entity\Acao::class,
                'display_empty_item' => false,
                'property'       => 'descricao',
                'is_method'      => true,
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
            'name' => 'quantidadePlantada',
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
            'name' => 'acao',
            'required' => false,
        ]);

//        $inputFilter->add([
//            'name' => 'estaca',
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
//                        'max' => 255
//                    ],
//                ],
//            ],
//        ]);
        
        $inputFilter->add([
            'name' => 'material',
            'required' => false,
        ]);
    }
}

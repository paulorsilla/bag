<?php

namespace Bag\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro de passaporte
 */
class ItemPedidoForm extends Form {

    protected $pesquisaCgs;
    protected $pesquisaAcesso;
    protected $pesquisaSinonimia;
    protected $objectManager;
    
    /**
     * Construtor
     */
    public function __construct($objectManager, $pesquisaCgs, $pesquisaAcesso, $pesquisaSinonimia) {
        //Determina o nome do formulário
        parent::__construct('item-pedido-form');

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
        
        //Adiciona o campo "quantidadeSolicitada"
        $this->add([
            'type' => 'text',
            'name' => 'quantidadeSolicitada',
            'attributes' => [
                'id' => 'quantidadeSolicitada',
                'class' => 'form-control',
                'place-holder' => 'Digite a quantidade solicitada aqui',
            ],
            'options' => [
                'label' => 'Quantidade solicitada'
            ],
        ]);
        
        //Adiciona o campo "quantidadeAtendida"
        $this->add([
            'type' => 'text',
            'name' => 'quantidadeAtendida',
            'attributes' => [
                'id' => 'quantidadeAtendida',
                'class' => 'form-control',
                'place-holder' => 'Digite a quantidade atendida aqui'
            ],
            'options' => [
                'label' => 'Quantidade atendida'
            ],
        ]);

        //Adiciona o campo "observacao"
        $this->add([
            'type' => 'text',
            'name' => 'observacao',
            'attributes' => [
                'id' => 'observacao',
                'class' => 'form-control',
                'place-holder' => 'Digite a observação aqui'
            ],
            'options' => [
                'label' => 'Observação'
            ],
        ]);
       
        //Adiciona o campo "material"
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
            'name' => 'quantidadeSolicitada',
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
            'name' => 'quantidadeAtendida',
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
                        'min' => 0,
                        'max' => 50
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
                        'max' => 512
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'material',
            'required' => true,
        ]);
    }
}

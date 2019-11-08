<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Bag;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'bag' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/bag',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    
                    'acao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/acao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\AcaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'avaliacao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/avaliacao[/:action[/:id][/:idRegeneracao]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\AvaliacaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    
                    'bag' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/bag[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\BagController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'caracteristica' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/caracteristica[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\CaracteristicaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'especie' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/especie[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\EspecieController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'estado' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/estado[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\EstadoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'genero' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/genero[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\GeneroController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'imagem' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/imagem[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ImagemController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
//                    'importacao-caderneta' => [
//                        'type' => Segment::class,
//                        'options' => [
//                            'route' => '/importacao-caderneta[/:action[/:id]]',
//                            'constraints' => [
//                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'id' => '[0-9]+'
//                            ],
//                            'defaults' => [
//                                'controller' => Controller\ImportacaoCadernetaController::class,
//                                'action' => 'index'
//                            ]
//                        ]
//                    ],
                    'instituicao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/instituicao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\InstituicaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'item-pedido' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/item-pedido[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ItemPedidoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'item-regeneracao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/item-regeneracao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ItemRegeneracaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'localizacao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/localizacao[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\LocalizacaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'material' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/material[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\MaterialController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'material-caracteristica' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/material-caracteristica[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\MaterialCaracteristicaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'material-tipo-bag' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/material-tipo-bag[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\MaterialTipoBagController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'modulo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/modulo[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ModuloController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'motivo' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/motivo[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\MotivoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'numeracao-estaca' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/numeracao-estaca[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\NumeracaoEstacaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'pais' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/pais[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\PaisController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'passaporte' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/passaporte[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\PassaporteController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'pedido' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/pedido[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\PedidoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'programa' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/programa[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\ProgramaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'regeneracao' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/regeneracao[/:action[/:id][/:status]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\RegeneracaoController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'regeneracao-caracteristica' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/regeneracao-caracteristica[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\RegeneracaoCaracteristicaController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'tipo-bag' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/tipo-bag[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => Controller\TipoBagController::class,
                                'action' => 'index'
                            ]
                        ]
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\AcaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\BagController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\CaracteristicaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\AvaliacaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\EspecieController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\EstadoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\GeneroController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ImagemController::class => Service\Factory\PadraoControllerFactory::class,
//            Controller\ImportacaoCadernetaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\InstituicaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ItemPedidoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ItemRegeneracaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\LocalizacaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\MaterialController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\MaterialCaracteristicaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\MaterialTipoBagController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ModuloController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\MotivoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\NumeracaoEstacaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\PaisController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\PassaporteController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\PedidoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\ProgramaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\RegeneracaoController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\RegeneracaoCaracteristicaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\SinonimiaController::class => Service\Factory\PadraoControllerFactory::class,
            Controller\TipoBagController::class => Service\Factory\PadraoControllerFactory::class,
        ],
    ],
    
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    
    'service_manager' => [
        'factories' => [
            Service\FileUpload::class => Service\Factory\FileUploadFactory::class
        ]
    ],
    
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'bag/index/index' => __DIR__ . '/../view/bag/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],

        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];

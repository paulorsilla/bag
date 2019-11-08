<?php

namespace DoctrineORMModule\Proxy\__CG__\Bag\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Material extends \Bag\Entity\Material implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function __get($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', [$name]);

        return parent::__get($name);
    }

    /**
     * {@inheritDoc}
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', [$name, $value]);

        return parent::__set($name, $value);
    }



    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'cgs', 'bracod', 'acesso', 'cultivar', 'observacao', 'especie', 'passaporte', 'bag', 'tiposBag', 'caracteristicas', 'programa'];
        }

        return ['__isInitialized__', 'id', 'cgs', 'bracod', 'acesso', 'cultivar', 'observacao', 'especie', 'passaporte', 'bag', 'tiposBag', 'caracteristicas', 'programa'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Material $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getCgs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCgs', []);

        return parent::getCgs();
    }

    /**
     * {@inheritDoc}
     */
    public function getBracod()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBracod', []);

        return parent::getBracod();
    }

    /**
     * {@inheritDoc}
     */
    public function getAcesso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAcesso', []);

        return parent::getAcesso();
    }

    /**
     * {@inheritDoc}
     */
    public function getCultivar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCultivar', []);

        return parent::getCultivar();
    }

    /**
     * {@inheritDoc}
     */
    public function getObservacao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObservacao', []);

        return parent::getObservacao();
    }

    /**
     * {@inheritDoc}
     */
    public function getEspecie()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEspecie', []);

        return parent::getEspecie();
    }

    /**
     * {@inheritDoc}
     */
    public function getTiposBag()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTiposBag', []);

        return parent::getTiposBag();
    }

    /**
     * {@inheritDoc}
     */
    public function getPassaporte()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPassaporte', []);

        return parent::getPassaporte();
    }

    /**
     * {@inheritDoc}
     */
    public function getBag()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBag', []);

        return parent::getBag();
    }

    /**
     * {@inheritDoc}
     */
    public function getCaracteristicas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCaracteristicas', []);

        return parent::getCaracteristicas();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrograma()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrograma', []);

        return parent::getPrograma();
    }

    /**
     * {@inheritDoc}
     */
    public function getCgsAcesso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCgsAcesso', []);

        return parent::getCgsAcesso();
    }

    /**
     * {@inheritDoc}
     */
    public function getImagens()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImagens', []);

        return parent::getImagens();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setCgs($cgs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCgs', [$cgs]);

        return parent::setCgs($cgs);
    }

    /**
     * {@inheritDoc}
     */
    public function setBracod($bracod)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBracod', [$bracod]);

        return parent::setBracod($bracod);
    }

    /**
     * {@inheritDoc}
     */
    public function setAcesso($acesso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAcesso', [$acesso]);

        return parent::setAcesso($acesso);
    }

    /**
     * {@inheritDoc}
     */
    public function setCultivar($cultivar)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCultivar', [$cultivar]);

        return parent::setCultivar($cultivar);
    }

    /**
     * {@inheritDoc}
     */
    public function setObservacao($observacao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setObservacao', [$observacao]);

        return parent::setObservacao($observacao);
    }

    /**
     * {@inheritDoc}
     */
    public function setEspecie($especie)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEspecie', [$especie]);

        return parent::setEspecie($especie);
    }

    /**
     * {@inheritDoc}
     */
    public function setTiposBag($tiposBag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTiposBag', [$tiposBag]);

        return parent::setTiposBag($tiposBag);
    }

    /**
     * {@inheritDoc}
     */
    public function setPassaporte($passaporte)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassaporte', [$passaporte]);

        return parent::setPassaporte($passaporte);
    }

    /**
     * {@inheritDoc}
     */
    public function setBag($bag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBag', [$bag]);

        return parent::setBag($bag);
    }

    /**
     * {@inheritDoc}
     */
    public function setCaracteristicas($caracteristicas)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCaracteristicas', [$caracteristicas]);

        return parent::setCaracteristicas($caracteristicas);
    }

    /**
     * {@inheritDoc}
     */
    public function setPrograma($programa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrograma', [$programa]);

        return parent::setPrograma($programa);
    }

    /**
     * {@inheritDoc}
     */
    public function setImagens($imagens)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImagens', [$imagens]);

        return parent::setImagens($imagens);
    }

    /**
     * {@inheritDoc}
     */
    public function setData($data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setData', [$data]);

        return parent::setData($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getData', []);

        return parent::getData();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', []);

        return parent::toArray();
    }

}

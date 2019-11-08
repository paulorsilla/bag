<?php

namespace DoctrineORMModule\Proxy\__CG__\Bag\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Modulo extends \Bag\Entity\Modulo implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'numero', 'lados', 'faces', 'niveis', 'espacos', 'localizacoes'];
        }

        return ['__isInitialized__', 'id', 'numero', 'lados', 'faces', 'niveis', 'espacos', 'localizacoes'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Modulo $proxy) {
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
    public function getNumero()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumero', []);

        return parent::getNumero();
    }

    /**
     * {@inheritDoc}
     */
    public function getLados()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLados', []);

        return parent::getLados();
    }

    /**
     * {@inheritDoc}
     */
    public function getFaces()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFaces', []);

        return parent::getFaces();
    }

    /**
     * {@inheritDoc}
     */
    public function getNiveis()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNiveis', []);

        return parent::getNiveis();
    }

    /**
     * {@inheritDoc}
     */
    public function getEspacos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEspacos', []);

        return parent::getEspacos();
    }

    /**
     * {@inheritDoc}
     */
    public function getLocalizacoes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocalizacoes', []);

        return parent::getLocalizacoes();
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
    public function setNumero($numero)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumero', [$numero]);

        return parent::setNumero($numero);
    }

    /**
     * {@inheritDoc}
     */
    public function setLados($lados)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLados', [$lados]);

        return parent::setLados($lados);
    }

    /**
     * {@inheritDoc}
     */
    public function setFaces($faces)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFaces', [$faces]);

        return parent::setFaces($faces);
    }

    /**
     * {@inheritDoc}
     */
    public function setNiveis($niveis)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNiveis', [$niveis]);

        return parent::setNiveis($niveis);
    }

    /**
     * {@inheritDoc}
     */
    public function setEspacos($espacos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEspacos', [$espacos]);

        return parent::setEspacos($espacos);
    }

    /**
     * {@inheritDoc}
     */
    public function setLocalizacoes($localizacoes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocalizacoes', [$localizacoes]);

        return parent::setLocalizacoes($localizacoes);
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
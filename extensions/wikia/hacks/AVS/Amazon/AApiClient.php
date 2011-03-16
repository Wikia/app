<?php
abstract class Amazon_AApiClient
{
    protected $_apiKey;
    protected $_apiSecretKey;
    protected $_countryCode;
    protected $_associateTag;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->setOptions($options);

        if (null == $this->_apiKey ||
            null == $this->_apiSecretKey ||
            null == $this->_countryCode ||
            null == $this->_associateTag) {
            throw new Exception('Amazon_AApiClient constructor is missing an option');
        }
    }

    /**
     * Options setter
     *
     * The options are:
     *  * apiKey
     *  * apiSecretKey
     *  * countryCode
     *  * associateTag
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
    }

    public function setOption($name, $value)
    {
        $name = '_' . $name;

        if (!property_exists($this, $name)) {
            throw new Exception(sprintf('Option "%s" does not exist', substr($name, 1)));
        }

        $this->$name = $value;
    }

    abstract public function itemLookup($asin, array $options = array());
    abstract public function itemSearch(array $options);
}
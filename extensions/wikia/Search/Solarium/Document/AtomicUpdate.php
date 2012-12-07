<?php

class Solarium_Document_AtomicUpdate extends Solarium_Document_ReadWrite
{
    /**
     * Allows us to determine what kind of atomic update we want to set
     * @var unknown_type
     */
    protected $_modifiers = array();
    
    /**
     * Directive to set a value using atomic updates
     * @var string
     */
    const MODIFIER_SET = 'set';
    
    /**
     * Directive to increment an integer value using atomic updates
     * @var string
     */
    const MODIFIER_INC = 'inc';
    
    /**
     * Directive to append a value (e.g. multivalued fields) using atomic updates
     * @var string
     */
    const MODIFIER_ADD = 'add';
    
    /**
     * Constructor 
     * 
     * @param array $fields
     * @param array $boosts
     * @param array $modifiers
     */
    public function __construct($fields = array(), $boosts = array(), $modifiers = array()) 
    {
        parent::__construct($fields, $boosts);
        $this->_modifiers = $modifiers;
    }
    
    /**
     * (non-PHPdoc)
     * @see Solarium_Document_ReadWrite::addField()
     */
    public function addField($key, $value, $boost = null, $modifier = self::MODIFIER_SET)
    {
        return parent::__addField($key, $value, $boost)->setModifierForField($key, $modifier);
    }
    
    /**
     * (non-PHPdoc)
     * @see Solarium_Document_ReadWrite::clear()
     */
    public function clear()
    {
        $this->_modifiers = array();
        return parent::clear();
    }
    
    /**
     * Sets the modifier type for the provided field
     * @param string $key
     * @param string $modifier
     * @throws Exception
     * @return Solarium_Document_AtomicUpdate
     */
    public function setModifierForField($key, $modifier = self::MODIFIER_SET)
    {
        if (! in_array($modifier, array(self::MODIFIER_ADD, self::MODIFIER_INC, self::MODIFIER_SET)) ) {
            throw new Exception('Attempt to set an atomic update modifier that is not supported');
        } 
        $this->_modifiers[$key] = $modifier;
        return $this;
    }
    
    /**
     * Returns the appropriate modifier for atomic updates. 
     * @param string $key
     * @return Ambigous <NULL, unknown_type>
     */
    public function getModifierForField($key)
    {
        return isset($this->_modifiers[$key]) ? $this->_modifiers[$key] : null; 
    }
}
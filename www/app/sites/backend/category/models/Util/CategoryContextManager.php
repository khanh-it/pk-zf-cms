<?php
/**
 * Class category context, for use with CategoryContextManager
 * @author khanhdtp
 */
class CategoryContext {
	/**
	 * @var array data
	 */
	protected $_data = array(
		// @var string code
		'code' => '',
		// @var array Name
		'name' => array(),
		// @var array Note
		'note' => array()
	);
	
	/**
	 * Contructor.
	 */
	public function __construct($data) {
		// Format, +set input data
		foreach ($data as $key => $value) {
			if (isset($this->_data[$key])) {
				$this->_data[$key] = $value;
			}
		}
		// Check data valid? 
		if (!$this->_data['code'] 
			|| !$this->_data['name']
		) {
			throw new Exception('Create context failed. Data provided invalid!');
		}
	}
	
	/**
	 * Get context's code
	 * @return string
	 */
	public function getCode() {
		return $this->_data['code'];
	}
	
	/**
	 * Get context's name
	 * @return string
	 */
	public function getName($lang = '') {
		$name = (array)$this->_data['name'];
		return $name[$lang];
	}
	
	/**
	 * Get context's note
	 * @return string
	 */
	public function getNote($lang = '') {
		$note = (array)$this->_data['note'];
		return $note[$lang];
	}
}


/**
 * Class category context
 * @author khanhdtp
 */
class Category_Model_Util_CategoryContextManager extends Default_Model_Util_Abstract
{
    /**
	 * Create new category context instance
	 * 
	 * @param array $data An array of data
	 * @return CategoryContext
	 */
	public function createContext($data) {
		// Return
		return new CategoryContext($data);
	}
	
	/**
	 * Contructor.
	 * 
	 * Noted:
	 *  [+] Make it `protected`, to force singletone designe pattern 
	 */
	protected function __construct() {}
	
	/**
     * Array of instance of objects extending CategoryContext
     *
     * @var array
     */
    protected $_contexts = array();


    /**
     * Register a context.
     *
     * @param  CategoryContext $context
     * @param  int $stackIndex
     * @return this
     */
    public function registerContext(CategoryContext $context, $stackIndex = null)
    {
        if (false !== array_search($context, $this->_contexts, true)) {
            throw new Exception('Context already registered');
        }

        $stackIndex = (int)$stackIndex;

        if ($stackIndex) {
            if (isset($this->_contexts[$stackIndex])) {
                throw new Exception('Context with stackIndex "' . $stackIndex . '" already registered');
            }
            $this->_contexts[$stackIndex] = $context;
        } else {
            $stackIndex = count($this->_contexts);
            while (isset($this->_contexts[$stackIndex])) {
                ++$stackIndex;
            }
            $this->_contexts[$stackIndex] = $context;
        }

        ksort($this->_contexts);

        return $this;
    }

    /**
     * Unregister a context.
     *
     * @param string|CategoryContext $context Context object or class name
     * @return this
     */
    public function unregisterContext($context)
    {
        if ($context instanceof CategoryContext) {
            // Given a context object, find it in the array
            $key = array_search($context, $this->_contexts, true);
            if (false === $key) {
                throw new Exception('Context never registered.');
            }
            unset($this->_contexts[$key]);
        } elseif (is_string($context)) {
            // Given a context class, find all contexts of that class and unset them
            foreach ($this->_contexts as $key => $_context) {
                $type = get_class($_context);
                if ($context == $type) {
                    unset($this->_contexts[$key]);
                }
            }
        }
        return $this;
    }

    /**
     * Is a context of a particular class registered?
     *
     * @param  string $class
     * @return bool
     */
    public function hasContext($class)
    {
    	if ($context instanceof CategoryContext) {
    		return array_search($context, $this->_contexts, true);
		} elseif (is_string($context)) {
	        foreach ($this->_contexts as $context) {
	            $type = get_class($context);
	            if ($class == $type) {
	                return true;
	            }
	        }
		}

        return false;
    }

    /**
     * Retrieve a context or contexts by class
     *
     * @param  string $class Class name of context(s) desired
     * @return false|CategoryContext|array Returns false if none found, context if only one found, and array of contexts if multiple contexts of same class found
     */
    public function getContext($class)
    {
        $found = array();
        foreach ($this->_contexts as $context) {
            $type = get_class($context);
            if ($class == $type) {
                $found[] = $context;
            }
        }

        switch (count($found)) {
            case 0:
                return false;
            case 1:
                return $found[0];
            default:
                return $found;
        }
    }

    /**
     * Retrieve all contexts
     *
     * @return array
     */
    public function getContexts()
    {
        return $this->_contexts;
    }  
}
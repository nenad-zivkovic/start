<?php
namespace app\components\db;

use \PDO;
use \PDOException;

/**
 * DBManager class file.
 *
 * @author Nenad Zivkovic <nenad@freetuts.org>
 * @copyright 2015 https://github.com/nenad-zivkovic
 * @license https://github.com/nenad-zivkovic/start/blob/master/LICENSE
 * @version 1.4 stable release
 */

/**
 * Class that is providing methods for writing and executing database queries.
 * It is using DBConnection for establishing a PDO connection.
 *
 * @requirements: PHP 5.3 or greater
 */
abstract class DBManager
{
    /**
     * Database handle.
     * 
     * @var PDO
     */
    private $_dbh;

    /**
     * The sql query.
     * 
     * @var string
     */
    private $_query;

    /**
     * Whether or not the user has specified the fetch mode.
     * 
     * @var boolean
     */
    private $_fetchMode = false;  

    /**
     * Statement handle
     * 
     * @var object
     */
    protected $_sth;

    /**
     * Exception errors.
     * 
     * @var string
     */
    protected $_error;

    /**
     * Table row data
     * 
     * @var array
     */
    protected $_data = array();
    
    // connection config
    protected $_dbDsn = null;
    protected $_dbUser = null;
    protected $_dbPass = null;
    protected $_dbOptions = null;
    protected $_dbForceOpenNewConn = false;
    protected $_dbCharset = null;
    protected $_dbName = null;
    protected $_dbHost = null;

    /**
     * Initializes the PDO database connection
     */
    public function __construct()
    {
        // tries to connect
        try {
            $this->_dbh = DBConnection::connect($this->getDbDsn(), $this->_dbUser, $this->_dbPass, 
                                                $this->_dbOptions, $this->_dbForceOpenNewConn);
        } catch (PDOException $e) { 
            $this->_error = $e->getMessage();      
        }
    }
    
    public function __get($name) 
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : null;
    }
    
    public function __set($name, $value) 
    {
        $this->_data[$name] = $value;
        return $this;
    }
    
    public function __isset($name) 
    {
    	return isset($this->_data[$name]);
    }
    
    public function __unset($name) 
    {
        unset($this->_data[$name]);
        return $this;
    }

//-----------------------------------------------------------------------
// Methods for custom query crafting and query execution
//-----------------------------------------------------------------------

    /**
     * Method that is accepting custom crafted sql query.
     * 
     * @param  mixed  $sql Your SQL query. Please use bind() method to bind values!
     * @return object      
     */
    public function query($sql)
    {
        $this->_query = $sql;
        $this->_sth = $this->_dbh->prepare($this->_query);      
        return $this;
    }

    /**
     * Public method that will invoke the private one called bindValues().
     * We do not want you to invoke bindValues directly since it is used internally in this class, 
     * and overriding it in wrong way can cause DB class malfunction.
     * If you need to change the way you are doing binding, you can change|override this method.
     * 
     * @param  mixed  $data The array|csv of values to be bound.
     * 
     * @return object
     */
    public function bind($data = [])
    {
        if (!is_array($data)) {
            $data = func_get_args();
        }

        return $this->bindValues($data);
    }

    /**
     * Specifies the fetch mode to be PDO::FETCH_ASSOC
     * 
     * @return $this
     */
    public function asArray()
    {
        $this->_fetchMode = $this->_sth->setFetchMode(PDO::FETCH_ASSOC);
        return $this;
    }

    /**
     * Executes the select type queries and returns a single record populated with the first row of data. 
     * You need to call this or all() method at the end of queries that are doing database read.
     * 
     * @return One table row.
     */
    public function one()
    {
        if (!$this->_fetchMode) {
            $this->_sth->setFetchMode(PDO::FETCH_CLASS, ucfirst(get_called_class()));
        } 

        $this->_sth->execute();
        return $this->_sth->fetch();         
    }

    /**
     * Executes the select type queries and returns all records based on the query results. 
     * You need to call this or one() method at the end of queries that are doing database read.
     * 
     * @return Table rows.
     */
    public function all()
    {
        if (!$this->_fetchMode) {
            $this->_sth->setFetchMode(PDO::FETCH_CLASS, ucfirst(get_called_class()));
        } 

        $this->_sth->execute();
        return $this->_sth->fetchAll();         
    }

    /**
     * Method that is executing custom crafted insert/update/delete queries.
     * 
     * @return integer If query is insert, it will return last inserted id, else the number of affected rows.
     */
    public function run()
    {
        $this->_sth->execute();

        // if this was an insert, return last inserted id
        if ($this->_dbh->lastInsertId()) {
            return $this->_dbh->lastInsertId();
        }
       
        // return number of affected rows
        return $this->_sth->rowCount();
    }

//-----------------------------------------------------------------------
// Helper methods
//-----------------------------------------------------------------------

    /**
     * Method that is binding values.
     * 
     * @param  array  $data The array with values to be bound.
     * @return object
     */
    private function bindValues($data)
    {
        $i = 1;

        // bind based on value type
        foreach ($data as $key => &$value) {

            // we have the inner array like $data = [[ 0 => 2, 1 => 4], 'not inner']
            if (is_array($value)) {

                foreach ($value as $innerKey => &$innerValue) {

                    if (is_int($innerValue)) {
                        $this->_sth->bindParam($i, $innerValue, PDO::PARAM_INT);
                    } elseif (is_bool($innerValue)) {
                        $this->_sth->bindParam($i, $innerValue, PDO::PARAM_BOOL);
                    } elseif (is_null($innerValue)) {
                        $this->_sth->bindParam($i, $innerValue, PDO::PARAM_NULL);
                    } else {
                        $this->_sth->bindParam($i, $innerValue, PDO::PARAM_STR);
                    }
                    $i++;
                }

            } else {

                if (is_int($value)) {
                    $this->_sth->bindParam($i, $value, PDO::PARAM_INT);
                } elseif (is_bool($value)) {
                    $this->_sth->bindParam($i, $value, PDO::PARAM_BOOL);
                } elseif (is_null($value)) {
                    $this->_sth->bindParam($i, $value, PDO::PARAM_NULL);
                } else {
                    $this->_sth->bindParam($i, $value, PDO::PARAM_STR);
                }

                $i++;
            }

        } // foreach

        return $this;
    }
	
//-----------------------------------------------------------------------
// Getters and Setters for databse connection configuration
//-----------------------------------------------------------------------

	/**
	 *
	 * @return string
	 */
	protected function getDbDsn() 
    {
		if (!isset($this->_dbDsn)) {
			if (isset($this->_dbHost) || isset($this->_dbName) || isset($this->_dbCharset)) {
				$this->_dbDsn = "mysql:host=" . $this->getDbHost() . ";" .
                                "dbname=" . $this->getDbName() . ";" . 
				                "charset=" . $this->getDbCharset() . "";
			}
		}
		return $this->_dbDsn;
	}
	
	/**
	 *
	 * @param string $dbDsn
	 * @return DB     	
	 */
	protected function setDbDsn($dbDsn) 
    {
		$this->_dbDsn = $dbDsn;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	protected function getDbUser() 
    {
		return $this->_dbUser;
	}
	
	/**
	 *
	 * @param string $dbUser        	
	 */
	protected function setDbUser($dbUser) 
    {
		$this->_dbUser = $dbUser;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	protected function getDbPass() 
    {
		return $this->_dbPass;
	}
	
	/**
	 *
	 * @param string $dbPass        	
	 */
	protected function setDbPass($dbPass) 
    {
		$this->_dbPass = $dbPass;
		return $this;
	}
	
	/**
	 *
	 * @return array
	 */
	protected function getDbOptions() 
    {
		return $this->_dbOptions;
	}
	
	/**
	 *
	 * @param array $dbOptions        	
	 */
	protected function setDbOptions($dbOptions) 
    {
		$this->_dbOptions = $dbOptions;
		return $this;
	}
	
	/**
	 *
	 * @return bool
	 */
	protected function getDbForceOpenNewConn() 
    {
		return $this->_dbForceOpenNewConn;
	}
	
	/**
	 *
	 * @param boolean $dbForceOpenNewConn        	
	 */
	protected function setDbForceOpenNewConn($dbForceOpenNewConn) 
    {
		$this->_dbForceOpenNewConn = $dbForceOpenNewConn;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	protected function getDbCharset() 
    {
		if (!isset($this->_dbCharset)) {
			$this->_dbCharset = DB_CHARSET;
		}
		return $this->_dbCharset;
	}
	
	/**
	 *
	 * @param string $dbCharset        	
	 */
	protected function setDbCharset($dbCharset) 
    {
		$this->_dbCharset = $dbCharset;
		$this->_dbDsn = null;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	protected function getDbName() 
    {
		if (!isset($this->_dbName)) {
			$this->_dbName = DB_NAME;
		}
		return $this->_dbName;
	}
	
	/**
	 *
	 * @param string $dbName        	
	 */
	protected function setDbName($dbName) 
    {
		$this->_dbName = $dbName;
		$this->_dbDsn = null;
		return $this;
	}
	
	/**
	 *
	 * @return the unknown_type
	 */
	protected function getDbHost() 
    {
		if (!isset($this->_dbHost)) {
			$this->_dbHost = DB_HOST;
		}
		return $this->_dbHost;
	}
	
	/**
	 *
	 * @param unknown_type $dbHost        	
	 */
	protected function setDbHost($dbHost) 
    {
		$this->_dbHost = $dbHost;
		$this->_dbDsn = null;
		return $this;
	}
	
}

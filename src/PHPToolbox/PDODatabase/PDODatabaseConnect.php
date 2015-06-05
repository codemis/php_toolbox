<?php
/**
 * This file is part of  PHPToolbox, a library of useful PHP code.
 *
 * PHPToolbox is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHPToolbox is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @author Johnathan Pulos <johnathan@missionaldigerati.org>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
/**
 * Declare the namespace
 *
 * @author Johnathan Pulos
 */
namespace PHPToolbox\PDODatabase;

use PDO;

/**
 * A Singleton class for handling the database connections
 *
 * @package default
 * @author Johnathan Pulos
 */
class PDODatabaseConnect
{
    /**
     * The PDO database instance of the class
     *
     * @access private
     * @var object
     */
    private static $PDODatabaseInstance;
    /**
     * The database settings
     *
     * @access private
     * @var array
     */
    private $databaseSettings = array();
    /**
     * The instance of the PDO database object
     *
     * @access private
     * @var object
     */
    private $PDO;
    /**
     * Construct the class,  this is set private to create a Singleton Class.  Please use getInstance to create the
     * class.
     *
     * @access private
     * @author Johnathan Pulos
     */
    private function __construct()
    {
    }
    /**
     * Set the database settings to use. The database settings array should have the keys: host, name, user, and
     *  password
     *
     * @param array $databaseSettings the database settings array
     * @access public
     * @author Johnathan Pulos
     */
    public function setDatabaseSettings($databaseSettings)
    {
        $this->databaseSettings = $databaseSettings->default;
    }
    /**
     * Get the instance of this class.
     *
     * @return object
     * @access public
     * @author Johnathan Pulos
     */
    public static function getInstance()
    {
        if (!self::$PDODatabaseInstance) {
            self::$PDODatabaseInstance = new PDODatabaseConnect();
        }
        return self::$PDODatabaseInstance;
    }
    /**
     * Get the database instance
     *
     * @return object
     * @access public
     * @author Johnathan Pulos
     */
    public function getDatabaseInstance()
    {
        if (!$this->PDO) {
            $this->PDO = $this->getConnection();
        }
        return $this->PDO;
    }
    /**
     * Make a connection to the database
     *
     * @return object
     * @access private
     * @author Johnathan Pulos
     */
    private function getConnection()
    {
        $dbhost = $this->databaseSettings['host'];
        $dbuser = $this->databaseSettings['username'];
        $dbpass = $this->databaseSettings['password'];
        $dbname = $this->databaseSettings['name'];
        try {
            $pdo = new \PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname . ";charset=utf8", $dbuser, $dbpass);
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            trigger_error(
                "Error!: " . $e->getMessage(),
                E_USER_ERROR
            );
        }
        return $pdo;
    }
}

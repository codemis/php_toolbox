<?php
/**
 * This file is part of Curl Utility.
 * 
 * Curl Utility is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Curl Utility is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see 
 * <http://www.gnu.org/licenses/>.
 *
 * @author Johnathan Pulos <johnathan@missionaldigerati.org>
 * @copyright Copyright 2012 Missional Digerati
 * 
 */
namespace PHPToolbox\PDODatabase;

/**
 * A test for the PDODatabaseConnect class
 *
 * @package default
 * @author Johnathan Pulos
 */
class PDODatabaseConnectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The PDODatabaseConnect Object
     *
     * @var object
     * @access private
     */
    private $pdoDatabaseConnect;
    /**
     * The database settings
     *
     * @var array
     * @access public
     */
    private $databaseSettings = array();
    /**
     * Setup the testing environment
     *
     * @return void
     * @access public
     * @author Johnathan Pulos
     */
    public function setUp()
    {
        $this->pdoDatabaseConnect = PDODatabaseConnect::getInstance();
        $this->databaseSettings = new \tests\support\DatabaseSettings;
    }
    /**
     * Checks if a connection can be made
     *
     * @covers PDODatabaseConnect::getDatabaseInstance
     * @access public
     * @author Johnathan Pulos
     */
    public function testShouldMakeADatabaseConnection()
    {
        $this->pdoDatabaseConnect->setDatabaseSettings($this->databaseSettings);
        $db = $this->pdoDatabaseConnect->getDatabaseInstance();
        $this->assertTrue(is_object($db));
        $this->assertEquals('PDO', get_class($db));
    }
    /**
     * Tests that an error is thrown with wrong credentials
     *
     * @expectedException PDOException
     * @covers PDODatabaseConnect::getDatabaseInstance
     * @access public
     * @author Johnathan Pulos
     */
    public function testGetDatabaseConnectionShouldErrorIfWrongCredentials()
    {
        $this->databaseSettings->default['password'] = 'WRONGPASS';
        $this->pdoDatabaseConnect->setDatabaseSettings($this->databaseSettings);
        $db = $this->pdoDatabaseConnect->getDatabaseInstance();
    }
}

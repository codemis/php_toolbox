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
     * Setup the testing environment
     *
     * @return void
     * @access public
     * @author Johnathan Pulos
     */
    public function setUp()
    {
        $this->pdoDatabaseConnect = PDODatabaseConnect::getInstance();
    }
    /**
     * PDODatabaseConnect::getInstance() should return the PDODatabaseConnect Instance
     *
     * @covers PDODatabaseConnect::getInstance
     * @access public
     * @author Johnathan Pulos
     */
    public function testGetInstanceShouldReturnInstanceOfClass()
    {
        $this->assertTrue(is_object($this->pdoDatabaseConnect));
        $this->assertEquals('PHPToolbox\PDODatabase\PDODatabaseConnect', get_class($this->pdoDatabaseConnect));
    }
    /**
     * For it to be a singleton, you should not be allowed to call the construct method
     *
     * @covers PDODatabaseConnect::__construct
     * @access public
     * @author Johnathan Pulos
     */
    public function testConstructShouldBePrivate()
    {
        $method = new \ReflectionMethod('PHPToolbox\PDODatabase\PDODatabaseConnect', '__construct');
        $this->assertTrue($method->isPrivate());
    }
}

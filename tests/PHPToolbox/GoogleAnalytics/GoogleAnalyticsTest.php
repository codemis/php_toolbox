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
namespace PHPToolbox\GoogleAnalytics;

/**
 * A test for the GoogleAnalytics class
 *
 * @package default
 * @author Johnathan Pulos
 */
class GoogleAnalyticsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The Google Analytics tracking id for testing
     *
     * @var string
     * @access private
     **/
    private $testTrackingId = 'UA-49359140-2';
    /**
     * The Google Analytics Object
     *
     * @var \PHPToolbox\GoogleAnalytics\GoogleAnalytics
     * @access private
     **/
    private $googleAnalytics;
    /**
     * Setup the tests
     *
     * @return void
     * @access public
     * @author Johnathan Pulos
     **/
    public function setUp()
    {
        $this->googleAnalytics = new GoogleAnalytics($this->testTrackingId);
    }
    /**
     * validatePayload() should validate a correct payload
     *
     * @return void
     * @access public
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadShouldCreateTheCorrectPayload()
    {
        $expectedPayload = array(
            'v' =>  1,
            'tid'   =>  $this->testTrackingId,
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'pageview',
            'dh'    =>  'missionaldigerati.org',
            'dp'    =>  '/test/test1.html'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $valid = $method->invoke($this->googleAnalytics, $expectedPayload);
        $this->assertTrue($valid);
    }
}

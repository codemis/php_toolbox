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
namespace PHPToolbox\CachedRequest;

/**
 * A test for the CurlUtility class
 *
 * @package default
 * @author Johnathan Pulos
 */
class CurlUtilityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The CurlUtility Object
     *
     * @var object
     * @access private
     */
    public $curlUtility;
    /**
     * Setup the testing environment
     *
     * @return void
     * @access public
     * @author Johnathan Pulos
     */
    public function setUp()
    {
        $this->curlUtility = new CurlUtility;
    }

    /**
     * Tests makeRequest() to assure it returns data
     *
     * @covers CurlUtility::makeRequest
     * @return void
     * @access public
     * @author Johnathan Pulos
     */
    public function testMakeRequestShouldSendRequest()
    {
        $results = $this->curlUtility->makeRequest(
            "http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots",
            "GET"
        );
        $this->assertTrue($results != '');
        $this->assertEquals($this->curlUtility->responseCode, 200);
    }

    /**
     * Tests urlify actually urlifies an array
     *
     * @covers CurlUtility::urlify
     * @return void
     * @access public
     * @author Johnathan Pulos
     */
    public function testUrlifyShouldConvertArrayToGETString()
    {
        $expected = "me=Johnathan&you=Programmer";
        $actual = $this->curlUtility->urlify(array("me" => "Johnathan", "you" => "Programmer"));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests makeRequest() to assure it sets the lastVisitedURL
     *
     * @covers CurlUtility::makeRequest
     * @return void
     * @author Johnathan Pulos
     **/
    public function testMakeRequestSetsLastVistedURL()
    {
        $expected = "http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots";
        $results = $this->curlUtility->makeRequest(
            $expected,
            "GET"
        );
        $actual = $this->curlUtility->lastVisitedURL;
        $this->assertTrue($actual != "");
        $exists = strpos($actual, $expected) !== false;
        $this->assertTrue($exists);
    }

    /**
     * Tests makeRequest() to assure it sets responseCode
     *
     * @covers CurlUtility::makeRequest
     * @return void
     * @author Johnathan Pulos
     **/
    public function testMakeRequestSetsResponseCode()
    {
        $default = $this->curlUtility->responseCode;
        $results = $this->curlUtility->makeRequest(
            "http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots",
            "GET"
        );
        $actual = $this->curlUtility->responseCode;
        $this->assertNotEquals($default, $actual);
        $this->assertEquals($this->curlUtility->responseCode, 200);
    }
}

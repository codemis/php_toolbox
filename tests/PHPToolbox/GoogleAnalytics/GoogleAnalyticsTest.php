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
     * __construct() should throw error if you do not send the tracking id
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testInitializerShouldSendErrorIfMissingATrackingId()
    {
        new GoogleAnalytics('');
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
            't'     =>  'pageview',
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
    /**
     * validatePayload() throws error if you pass a bad key
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouPassABadKey()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'bad_key'   =>  'GoogleAnalyticsTest'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non boolean value for aip
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonBooleanForAIP()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'aip'   =>  'GoogleAnalyticsTest'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non boolean value for je
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonBooleanForJE()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'je'    =>  'GoogleAnalyticsTest'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non boolean value for ni
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonBooleanForNI()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'ni'    =>  'GoogleAnalyticsTest'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non boolean value for exf
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonBooleanForEXF()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'exf'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() should pass even if boolean var is string
     *
     * @return void
     * @access public
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadShouldPassEvenIfBooleanIsAString()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'exf'   =>  1
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $valid = $method->invoke($this->googleAnalytics, $expectedPayload);
        $this->assertTrue($valid);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for qt
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForQT()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'qt'    =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for ev
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForEV()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'ev'    =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for iq
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForIQ()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'iq'    =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for utt
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForUTT()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'utt'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for plt
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForPLT()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'plt'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for dns
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForDNS()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'dns'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for pdt
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForPDT()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'pdt'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for rrt
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForRT()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'rrt'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for tcp
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForTCP()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'tcp'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if you pass a non integer value for srt
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfYouNonIntegerForSRT()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'cid'   =>  'GoogleAnalyticsTest',
            'srt'   =>  'test'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if the required key cid is not set
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfMissingRequiredCID()
    {
        $expectedPayload = array(
            't'     =>  'pageview',
            'srt'   =>  10
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() throws error if the required key t is not set
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfMissingRequiredT()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            'srt'   =>  10
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() if hit type (t) is transaction, it throws error if your missing ti
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfTransactionHitMissingRequiredTI()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'transaction',
            'srt'   =>  10
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() if hit type (t) is item, it throws error if your missing ti
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfItemHitMissingRequiredTI()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'item',
            'srt'   =>  10
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() if hit type (t) is item, it throws error if your missing in
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfItemHitMissingRequiredIN()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'item',
            'ti'    =>  'a_good_product',
            'srt'   =>  10
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() if hit type (t) is social, it throws error if your missing sn
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfSocialHitMissingRequiredSN()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'social',
            'srt'   =>  10,
            'sa'    =>  'like',
            'st'    =>  'http%3A%2F%2Ffoo.com'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() if hit type (t) is social, it throws error if your missing sa
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfSocialHitMissingRequiredSA()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'social',
            'srt'   =>  10,
            'sn'    =>  'facebook',
            'st'    =>  'http%3A%2F%2Ffoo.com'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
    /**
     * validatePayload() if hit type (t) is social, it throws error if your missing st
     *
     * @return void
     * @access public
     * @expectedException InvalidArgumentException
     * @author Johnathan Pulos
     **/
    public function testValidatePayloadThrowsErrorIfSocialHitMissingRequiredST()
    {
        $expectedPayload = array(
            'cid'   =>  'GoogleAnalyticsTest',
            't'     =>  'social',
            'srt'   =>  10,
            'sn'    =>  'facebook',
            'sa'    =>  'like'
        );
        $googleAnalytics = new \ReflectionClass('\PHPToolbox\GoogleAnalytics\GoogleAnalytics');
        $method = $googleAnalytics->getMethod('validatePayload');
        $method->setAccessible(true);
        $method->invoke($this->googleAnalytics, $expectedPayload);
    }
}

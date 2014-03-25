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
namespace PHPToolbox\CachedRequest;

/**
 * A test for the CachedRequest class
 *
 * @package default
 * @author Johnathan Pulos
 */
class CachedRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The cachedRequest Object
     *
     * @var object
     * @access private
     */
    public $cachedRequest;
    /**
     * Setup the testing environment
     *
     * @access public
     * @author Johnathan Pulos
     */
    public function setUp()
    {
        $this->cachedRequest = new CachedRequest;
    }
    /**
     * tearDown the testing class
     *
     * @access public
     * @author Johnathan Pulos
     */
    public function tearDown()
    {
        $this->cachedRequest->clearCache();
    }
    /**
     * Tests to make sure the class can be initialized, and sets up the class correctly
     *
     * @access public
     * @author Johnathan Pulos
     */
    public function testClassShouldSetTheAppropriateVariables()
    {
        $this->assertFalse($this->cachedRequest->cacheDirectory == '');
    }
    /**
     * the clearCache() functions should empty the cache directory
     *
     * @covers CachedResult::clearCache
     * @access public
     * @author Johnathan Pulos
     */
    public function testClearCacheShouldEmptyCacheDirectory()
    {
        $reference = "new_file";
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->createIfNotExistantFile($cachedFile);
        $this->cachedRequest->clearCache();
        $this->assertFalse(file_exists($cachedFile));
    }
    /**
     * the clearCachedFileByReference() functions should remove the file associated to that reference
     *
     * @covers CachedRequest::clearCachedFileByReference
     * @access public
     * @author Johnathan Pulos
     */
    public function testClearCacheFileByReferenceShouldRemoveTheCachedFile()
    {
        $reference = 'unreached_people';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->createIfNotExistantFile($cachedFile);
        $this->cachedRequest->clearCachedFileByReference($reference);
        $this->assertFalse(file_exists($cachedFile));
    }
    /**
     * the getCacheFilename() function should return a filename with the reference in it
     *
     * @covers CachedResult::getCacheFilename
     * @access public
     * @author Johnathan Pulos
     */
    public function testGetCacheFilenameShouldReturnNameWithReference()
    {
        $reference = 'unreached_people';
        $filename = $this->cachedRequest->getCacheFilename($reference);
        $present = strpos($filename, $reference);
        $this->assertTrue($present !== false);
    }
    /**
     * Tests that makeRequest() creates the cache file
     *
     * @covers CachedRequest::makeRequest
     * @access public
     * @author Johnathan Pulos
     */
    public function testMakeRequestShouldCreateACacheFile()
    {
        $reference = 'giant_smashing_robots';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->removeIfFileExists($cachedFile);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'makeRequest');
        $method->setAccessible(true);
        $method->invoke(
            $this->cachedRequest,
            'GET',
            'http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots',
            array(),
            $reference
        );
        $this->assertTrue(file_exists($cachedFile));
    }
    /**
     * Test that makeRequest() calls the CurlUtility class if the cache file is not created
     *
     * @access public
     * @author Johnathan Pulos
     */
    public function testMakeRequestShouldGrabTheWebsiteContentIfNoCache()
    {
        $reference = 'giant_smashing_robots_with_mock';
        $expected = '<html><body><p>I AM A FAKE!</p></body></html>';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->removeIfFileExists($cachedFile);
        /**
         * Setup a Mock for the CurlUtility
         *
         * @author Johnathan Pulos
         */
        $curlUtilityMock = $this->getMock('PHPToolbox\CachedRequest\CurlUtility', array('makeRequest'));
        $curlUtilityMock->expects($this->once())
            ->method('makeRequest')
            ->with('http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots', 'GET', array())
            ->will($this->returnValue($expected));
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'setCurlUtilityObject');
        $method->setAccessible(true);
        $method->invoke($this->cachedRequest, $curlUtilityMock);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'makeRequest');
        $method->setAccessible(true);
        $results = $method->invoke(
            $this->cachedRequest,
            'GET',
            'http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots',
            array(),
            $reference
        );
        $this->assertEquals($expected, $results);
    }
    /**
     * Test that makeRequest() does not call the CurlUtility class if the cache file exists
     *
     * @access public
     * @author Johnathan Pulos
     */
    public function testMakeRequestShouldNotGrabTheWebsiteContentIfCached()
    {
        $reference = 'giant_smashing_robots_with_mock_cached';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->createIfNotExistantFile($cachedFile);
        /**
         * Setup a Mock for the CurlUtility
         *
         * @author Johnathan Pulos
         */
        $curlUtilityMock = $this->getMock('CurlUtility', array('makeRequest'));
        $curlUtilityMock->expects($this->never())->method('makeRequest');
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'setCurlUtilityObject');
        $method->setAccessible(true);
        $method->invoke($this->cachedRequest, $curlUtilityMock);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'makeRequest');
        $method->setAccessible(true);
        $method->invoke(
            $this->cachedRequest,
            'GET',
            'http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots',
            array(),
            $reference
        );
    }
    /**
     * Tests makeRequest() sets the responseCode correctly
     *
     * @return void
     * @author Johnathan Pulos
     **/
    public function testMakeRequestSetsResponseCode()
    {
        $default = $this->cachedRequest->responseCode;
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'makeRequest');
        $method->setAccessible(true);
        $method->invoke(
            $this->cachedRequest,
            'GET',
            'http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots',
            array(),
            'giant_smashing_robots_with_mock_cached'
        );
        $actual = $this->cachedRequest->responseCode;
        $this->assertNotEquals($default, $actual);
        $this->assertEquals($this->cachedRequest->responseCode, 200);
    }
    /**
     * Tests makeRequest() sets the lastVisitedURL correctly
     *
     * @return void
     * @author Johnathan Pulos
     **/
    public function testMakeRequestSetsLastVisitedURL()
    {
        $expected = "http://feeds.feedburner.com/GiantRobotsSmashingIntoOtherGiantRobots";
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'makeRequest');
        $method->setAccessible(true);
        $method->invoke(
            $this->cachedRequest,
            'GET',
            $expected,
            array(),
            'giant_smashing_robots_with_mock_cached'
        );
        $actual = $this->cachedRequest->lastVisitedURL;
        $this->assertTrue($actual != "");
        $exists = strpos($actual, $expected) !== false;
        $this->assertTrue($exists);
    }
    /**
     * Tests that writeCacheFile() writes content to a cache file
     * 
     * @covers CachedResult::writeCacheFile
     * @access public
     * @author Johnathan Pulos
     */
    public function testWriteCacheFileShouldCreateAndWriteTheCachedFile()
    {
        $reference = 'giant_smashing_robots_again';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->removeIfFileExists($cachedFile);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'writeCacheFile');
        $method->setAccessible(true);
        $method->invoke($this->cachedRequest, 'Here is some content.', $reference);
        $this->assertTrue(file_exists($cachedFile));
        $this->assertFalse(0 == filesize($cachedFile));
    }
    /**
     * Tests that isCached() responds true if the file exists
     *
     * @covers CachedResult::isCached
     * @access public
     * @author Johnathan Pulos
     */
    public function testIsCachedShouldReturnTrueIfFileExists()
    {
        $reference = 'i_am_a_cached_file';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->createIfNotExistantFile($cachedFile);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'isCached');
        $method->setAccessible(true);
        $exists = $method->invoke($this->cachedRequest, $reference);
        $this->assertTrue($exists);
    }
    /**
     * Tests that isCached() responds false if the file does not exist
     *
     * @covers CachedResult::isCached
     * @access public
     * @author Johnathan Pulos
     */
    public function testIsCachedShouldReturnFalseIfNoFileExists()
    {
        $reference = 'i_am_an_uncached_file';
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->removeIfFileExists($cachedFile);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'isCached');
        $method->setAccessible(true);
        $exists = $method->invoke($this->cachedRequest, $reference);
        $this->assertFalse($exists);
    }
    /**
     * Tests that isCached() responds false if the file has expired
     *
     * @covers CachedResult::isCached
     * @access public
     * @author Johnathan Pulos
     */
    public function testIsCachedShouldReturnFalseIfExpired()
    {
        $reference = 'i_am_an_outdated_cache_file';
        $this->cachedRequest->cacheTime = 0;
        $cachedFile = $this->cachedRequest->getCacheFilename($reference);
        $this->createIfNotExistantFile($cachedFile);
        sleep(1);
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'isCached');
        $method->setAccessible(true);
        $exists = $method->invoke($this->cachedRequest, $reference);
        $this->assertFalse($exists);
    }

    /**
     * Test that safeFilename() produces a safe filename for storage
     *
     * @covers CachedRequest::safeFilename
     * @access public
     * @author Johnathan Pulos
     */
    public function testSafeFilenameMakesItSafe()
    {
        $reference = '#$i am ^&a bad ()@##name';
        $expected = 'iamabadname';
        $method = new \ReflectionMethod('PHPToolbox\CachedRequest\CachedRequest', 'safeFilename');
        $method->setAccessible(true);
        $actual = $method->invoke($this->cachedRequest, $reference);
        $this->assertEquals($expected, $actual);
    }
    /**
     * If the file does not exist, then create it
     *
     * @param string $file the file to create
     * @access private
     * @author Johnathan Pulos
     */
    private function createIfNotExistantFile($file)
    {
        if (!file_exists($file)) {
            $fh = fopen($file, 'w');
            fclose($fh);
        }
    }
    /**
     * If the file exists, then remove it
     *
     * @param string $file the file to create
     * @access private
     * @author Johnathan Pulos
     */
    private function removeIfFileExists($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }
}

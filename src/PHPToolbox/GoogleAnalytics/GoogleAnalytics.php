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
 * A class for sending information to the Google Analytics service via PHP.
 *
 * @package default
 * @author Johnathan Pulos
 */
class GoogleAnalytics
{
    /**
     * The version number of the Google Analytics API
     *
     * @var integer
     * @access public
     **/
    public $apiVersion = 1;
    /**
     * The Google Analytics tracking id
     *
     * @var string
     * @access private
     **/
    private $trackingId;
    /**
     * An array of valid keys that can be passed in the payload.  To find out more,
     * check out https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters.
     *
     * @var array
     * @access private
     **/
    private $validPayloadKeys = array(
        'aip', 'qt', 'z', 'cid', 'sc', 'dr', 'cn', 'cs', 'cm', 'ck', 'cc', 'ci', 'gclid', 'dclid', 'sr', 'vp',
        'de', 'sd', 'ul', 'je', 'fl', 't', 'ni', 'dl', 'dh', 'dp', 'dt', 'cd', 'linkid', 'an', 'av', 'ec', 'ea',
        'el', 'ev', 'ti', 'ta', 'tr', 'ts', 'tt', 'in', 'ip', 'iq', 'ic', 'iv', 'cu', 'sn', 'sa', 'st', 'utc',
        'utv', 'utt', 'utl', 'plt', 'dns', 'pdt', 'rrt', 'tcp', 'srt', 'exd', 'exf'
    );
    /**
     * Initialize the class
     *
     * @return void
     * @access public
     * @throws \InvalidArgumentException when you are missing a tracking id
     * @author Johnathan Pulos
     **/
    public function __construct($trackingId = '')
    {
        if ($trackingId == '') {
            throw new \InvalidArgumentException("Missing the required parameter trackingId.");
        }
        $this->trackingId = $trackingId;
    }
    /**
     * validates the given payload to be sent to Google
     *
     * @return boolean
     * @access private
     * @throws \InvalidArgumentException If you pass an unacceptable key
     * @author Johnathan Pulos
     **/
    private function validatePayload($payload)
    {
        foreach ($payload as $key => $value) {
            if (!in_array($key, $this->validPayloadKeys)) {
                throw new \InvalidArgumentException("The following parameter is invalid: " . $key);
            }
        }
        return true;
    }
}

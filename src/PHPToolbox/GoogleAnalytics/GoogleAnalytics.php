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
 * A class for sending information to the Google Analytics service via PHP.  You will need to include
 *  the CurlUtility class in this library to use
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
     * The URL to send requests
     *
     * @var string
     * @access private
     **/
    private $url = 'http://www.google-analytics.com/collect';
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
     * The cURL Utility in this library
     *
     * @var \PHPToolbox\CachedRequest\CurlUtility
     **/
    private $curlUtility;
    /**
     * An array of valid Hit Types for Google Analytics
     *
     * @var array
     * @access private
     **/
    private $validHitTypes = array(
        'pageview', 'appview', 'event', 'transaction', 'item', 'social', 'exception', 'timing'
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
        $this->curlUtility = new \PHPToolbox\CachedRequest\CurlUtility();
    }
    /**
     * Save the payload to Google Analytics
     *
     * @param array $payload an array of options to send to Google Analytics
     * @return boolean did it save?
     * @access public
     * @author Johnathan Pulos
     **/
    public function save($payload)
    {
        if ($this->validatePayload($payload)) {
            $payload['v'] = $this->apiVersion;
            $payload['tid'] = $this->trackingId;
            $payloadValues = array();
            foreach ($payload as $key => $val) {
                array_push($payloadValues, $key . "=" . urlencode($val));
            }
            $encodedPayload = implode("&", $payloadValues);
            $result = $this->curlUtility->makeRequest($this->url, 'POST', $encodedPayload);
            if ($this->curlUtility->responseCode == 200) {
                return true;
            } else {
                return false;
            }
        }
    }
    /**
     * validates the given payload to be sent to Google
     *
     * @return boolean
     * @access private
     * @throws \InvalidArgumentException If you pass an unacceptable key
     * @throws \InvalidArgumentException If exf, ni, je, or aip is not a boolean integer of 0 or 1
     * @throws \InvalidArgumentException If dns, ev, iq, pdt, plt, qt, rrt, srt, tcp, utt are not integers
     * @throws \InvalidArgumentException If cid is not set
     * @throws \InvalidArgumentException If t is not set
     * @throws \InvalidArgumentException If t=transaction but ti is not set
     * @throws \InvalidArgumentException If t=item but ti and in are not set
     * @throws \InvalidArgumentException If t=social but sn, sa, and st are not set
     * @throws \InvalidArgumentException If t is not an accetable value
     * @author Johnathan Pulos
     **/
    private function validatePayload($payload)
    {
        foreach ($payload as $key => $value) {
            if (!in_array($key, $this->validPayloadKeys)) {
                throw new \InvalidArgumentException("The following parameter is invalid: " . $key);
            }
            switch ($key) {
                case 'exf':
                case 'ni':
                case 'je':
                case 'aip':
                    if ((is_string($value)) || (($value != 0) && ($value != 1))) {
                        throw new \InvalidArgumentException(
                            "The following parameter must be a boolean integer either 0 or 1: " . $key
                        );
                        return false;
                    }
                    break;
                case 'dns':
                case 'ev':
                case 'iq':
                case 'pdt':
                case 'plt':
                case 'qt':
                case 'rrt':
                case 'srt':
                case 'tcp':
                case 'utt':
                    if (!is_integer($value)) {
                        throw new \InvalidArgumentException(
                            "The following parameter must be an integer: " . $key
                        );
                        return false;
                    }
                    break;
            }
        }
        if (!array_key_exists('cid', $payload)) {
            throw new \InvalidArgumentException(
                "The following parameter is required: cid"
            );
            return false;
        }
        if (!array_key_exists('t', $payload)) {
            throw new \InvalidArgumentException(
                "The following parameter is required: t"
            );
            return false;
        }
        if (!in_array($payload['t'], $this->validHitTypes)) {
            throw new \InvalidArgumentException(
                "The hit type (t) must be a valid value."
            );
            return false;
        }
        if (($payload['t'] == 'transaction') && (!array_key_exists('ti', $payload))) {
            throw new \InvalidArgumentException(
                "The following parameter is required for transaction based hit types: ti"
            );
            return false;
        }
        if ($payload['t'] == 'item') {
            if (!array_key_exists('ti', $payload)) {
                throw new \InvalidArgumentException(
                    "The following parameter is required for item based hit types: ti"
                );
                return false;
            }
            if (!array_key_exists('in', $payload)) {
                throw new \InvalidArgumentException(
                    "The following parameter is required for item based hit types: in"
                );
                return false;
            }
        }
        if ($payload['t'] == 'social') {
            if (!array_key_exists('sn', $payload)) {
                throw new \InvalidArgumentException(
                    "The following parameter is required for social based hit types: sn"
                );
                return false;
            }
            if (!array_key_exists('sa', $payload)) {
                throw new \InvalidArgumentException(
                    "The following parameter is required for social based hit types: sa"
                );
                return false;
            }
            if (!array_key_exists('st', $payload)) {
                throw new \InvalidArgumentException(
                    "The following parameter is required for social based hit types: st"
                );
                return false;
            }
        }
        return true;
    }
}

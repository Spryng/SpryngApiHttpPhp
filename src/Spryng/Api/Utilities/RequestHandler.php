<?php

/**
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 */

namespace SpryngApiHttpPhp\Utilities;

/**
 * Class RequestHandler
 * @package SpryngApiHttpPhp\Utilities
 */
class RequestHandler
{

    /**
     * GuzzleHttp Client
     *
     * @var resource
     */
    protected $http;

    /**
     * The HTTP method used for this request
     *
     * @var string
     */
    protected $httpMethod;

    /**
     * The base URL for the requests
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * The query string, basically everything after baseUrl
     *
     * @var string
     */
    protected $queryString;

    /**
     * Array of GET parameters
     *
     * @var array
     */
    protected $getParameters = array();

    /**
     * Response from the request
     *
     * @var mixed
     */
    protected $response;

    /**
     * HTTP response code resulting from the latest request.
     *
     * @var int
     */
    protected $responseCode;

    /**
     * Array of HTTP Headers
     *
     * @var array
     */
    protected $headers;

    /**
     * Spryng_Api_Utilities_RequestHandler constructor.
     */
    public function __construct()
    {
        $this->http = curl_init();
        $this->addHeader('User-Agent', 'SpryngApiHttpPhp/1.4.0');
        $this->addHeader('Accept', '*/*');
        $this->addHeader('Accept-Encoding', 'gzip, deflate, br');
    }

    /**
     * Formats the URL and executes the request
     */
    public function doRequest ()
    {
        curl_setopt($this->http, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($this->http, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->http, CURLOPT_URL, $this->prepareUrl());

        // set http method
        $method = $this->getHttpMethod() === 'POST' ? CURLOPT_POST : CURLOPT_GET;
        curl_setopt($this->http, $method, true);

        $response = curl_exec($this->http);
        $this->setResponse($response);
        $this->setResponseCode(curl_getinfo($this->http, CURLINFO_RESPONSE_CODE));
    }

    /**
     * Formats the URL.
     *
     * @return string
     */
    private function prepareUrl()
    {
        $url = $this->getBaseUrl() . $this->getQueryString();

        if (count($this->getGetParameters()) > 0)
        {
            $url .= '?';
            $iterator = 0;
            foreach ($this->getGetParameters() as $key => $parameter)
            {
                $iterator++;
                $url .= $key . '=' . $parameter;

                if ($iterator != count($this->getGetParameters()))
                {
                    $url .= '&';
                }
            }
        }

        return $url;
    }

    /**
     * Returns HTTP method
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Sets HTTP method
     *
     * @param string $httpMethod
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * Returns baseUrl
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Sets baseUrl
     *
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Returns the Query String
     *
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * Sets the Query String
     *
     * @param string $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * Returns array of all GET parameters
     *
     * @return array
     */
    public function getGetParameters()
    {
        return $this->getParameters;
    }

    /**
     * Reset $this->getParameters to $getParameters. Parses as url if $parse is true.
     *
     * @param $getParameters
     * @param bool|false $parse
     */
    public function setGetParameters($getParameters, $parse = false)
    {
        $this->getParameters = array();
        if ($parse) {
            foreach ($getParameters as $key => $parameter)
            {
                $this->getParameters[$key] = urlencode($parameter);
            }
        }
        else {
            $this->getParameters = $getParameters;
        }
    }

    /**
     * Adds a new parameter to the GET parameter array
     *
     * @param $value
     * @param null $key
     * @param bool|false $parse
     */
    public function addGetParameter($value, $key = null, $parse = false)
    {
        if ($parse)
        {
            $value = urlencode($value);
        }

        if ($key === null)
        {
            array_push($this->getParameters, $value);
        }
        else
        {
            $this->getParameters[$key] = $value;
        }
    }

    /**
     * Returns the response
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the response
     *
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Add a HTTP header
     *
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Returns protected headers class variable.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the protected responseCode class variable
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Internal function to set the response code.
     *
     * @param int $responseCode
     */
    private function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }
}

<?php

use GuzzleHttp\Client;

/**
 * Handles HTTP requests
 *
 * @license         Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author          Roemer Bakker
 * @copyright       Complexity Software
 *
 */
class Spryng_Api_Utilities_RequestHandler
{

    /**
     * @var GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $httpMethod;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $queryString;

    /**
     * @var array
     */
    protected $getParameters = array();

    protected $response;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function doRequest ()
    {
        $url = $this->getBaseUrl() . $this->getQueryString();

        if ( count( $this->getGetParameters () ) > 0 )
        {
            $url .= '?';

            $iterator = 0;
            foreach ( $this->getGetParameters() as $key => $parameter )
            {
                $iterator++;
                $url .= urlencode( $key ) . '=' . urlencode( $parameter );

                if ( $iterator != count ( $this->getGetParameters() ) )
                {
                    $url .= '&';
                }
            }

            $req = $this->httpClient->request($this->getHttpMethod(), $url);

            $this->setResponse( (string) $req->getBody() );
        }
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @param string $httpMethod
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param string $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * @return array
     */
    public function getGetParameters()
    {
        return $this->getParameters;
    }

    /**
     * @param array $getParameters
     */
    public function setGetParameters($getParameters)
    {
        $this->getParameters = $getParameters;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
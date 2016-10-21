<?php
namespace Rg\Client;

class CurlClient
{
    /**
     * @var int
     */
    protected $connectionTimeout;

    /**
     * @var int
     */
    protected $connectionWaitTimeout;

    /**
     * @param int $connectionTimeout
     * @param int $connectionWaitTimeout
     */
    public function __construct($connectionTimeout = 15, $connectionWaitTimeout = 5)
    {
        $this->connectionTimeout = $connectionTimeout;
        $this->connectionWaitTimeout = $connectionWaitTimeout;
    }

    /**
     * @param string $url
     * @param string[] $parameters
     *
     * @return bool|string
     */
    public function send($url, array $parameters)
    {
        $curlHandler = curl_init();

        curl_setopt_array($curlHandler, $this->getCurlOptions($url, $parameters));

        $curlExecutionResult = $this->curlExec($curlHandler);
        $curlExecutionInformation = $this->curlGetInfo($curlHandler);

        curl_close($curlHandler);

        if (true === isset($curlExecutionInformation['http_code'])
            && 0 !== $curlExecutionInformation['http_code']
        ) {
            return $curlExecutionResult;
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @param array $parameters
     *
     * @return array
     */
    protected function getCurlOptions($url, $parameters)
    {
        $curlOptions = [
            CURLOPT_URL => $url . '?' . $this->createQueryFromParameters($parameters),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => $this->connectionWaitTimeout,
            CURLOPT_TIMEOUT => $this->connectionTimeout,
        ];

        return $curlOptions;
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    protected function createQueryFromParameters(array $parameters)
    {
        return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * @param resource $curlHandler
     *
     * @return mixed|string
     */
    protected function curlExec($curlHandler)
    {
        return curl_exec($curlHandler);
    }

    /**
     * @param resource $curlHandler
     *
     * @return mixed|array
     */
    protected function curlGetInfo($curlHandler)
    {
        return curl_getinfo($curlHandler);
    }
}

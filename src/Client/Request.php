<?php

declare(strict_types=1);

namespace Yggverse\Nex\Client;

class Request
{
    private ?string $_ip = null;

    private string $_host;
    private int    $_port;
    private string $_path;
    private string $_query;

    private array $_options = [];

    public function __construct(string $url, ?string $ip = null)
    {
        if ($host = parse_url($url,  PHP_URL_HOST))
        {
            $this->setHost(
                $host
            );
        }

        else
        {
            throw new Exception(); // @TODO
        }

        if ($port = parse_url($url,  PHP_URL_PORT))
        {
            $this->setPort(
                $port
            );
        }

        else
        {
            $this->setPort(
                1900
            );
        }

        if ($path = parse_url($url,  PHP_URL_PATH))
        {
            $this->setPath(
                $path
            );
        }

        else
        {
            $this->setPath(
                ''
            );
        }

        if ($query = parse_url($url,  PHP_URL_QUERY))
        {
            $this->setQuery(
                $query
            );
        }

        else
        {
            $this->setQuery(
                ''
            );
        }

        if ($ip && false !== filter_var($ip, FILTER_VALIDATE_IP))
        {
            $this->setResolvedHost(
                $ip
            );
        }
    }

    public function setOptions(array $value): void
    {
        $this->_options = $value;
    }

    public function getOptions(): array
    {
        return $this->_options;
    }

    public function setHost(string $value): void
    {
        $this->_host = $value;
    }

    public function getHost(): string
    {
        return $this->_host;
    }

    public function setPort(int $value): void
    {
        $this->_port = $value;
    }

    public function getPort(): int
    {
        return $this->_port;
    }

    public function setPath(string $value): void
    {
        $this->_path = $value;
    }

    public function getPath(): string
    {
        return $this->_path;
    }

    public function setQuery(string $value): void
    {
        $this->_query = $value;
    }

    public function getQuery(): string
    {
        return $this->_query;
    }

    public function setResolvedHost(?string $value): void
    {
        $this->_ip = $value;
    }

    public function getResolvedHost(): ?string
    {
        return $this->_ip;
    }

    public function getResponse(
        int $timeout = 30, // socket timeout, useful for offline resources
        ?int $limit = null, // content length, null for unlimited
        ?int &$length = 0, // initial response length, do not change without special needs
        ?int &$code = null, // error code for debug
        ?string &$message = null, // error message for debug
        string &$response = '' // response init, also returning by this method
    ): ?string
    {
        $connection = stream_socket_client(
            sprintf(
                'tcp://%s:%d',
                $this->_ip ? $this->_ip : $this->_host,
                $this->_port
            ),
            $code,
            $message,
            $timeout,
            STREAM_CLIENT_CONNECT,
            stream_context_create(
                $this->_options
            )
        );

        if (!is_resource($connection))
        {
            return null;
        }

        fwrite(
            $connection,
            sprintf(
                "nex://%s:%d%s%s\r\n",
                $this->_host,
                $this->_port,
                $this->_path,
                $this->_query
            )
        );

        while ($part = fgets($connection))
        {
            $length = $length + mb_strlen(
                $part
            );

            if ($limit && $length > $limit)
            {
                break;
            }

            $response .= $part;
        }

        fclose(
            $connection
        );

        return $response;
    }
}
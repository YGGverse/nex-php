<?php

declare(strict_types=1);

namespace Yggverse\Nex;

class Client
{
    private string $_host;
    private int    $_port;
    private string $_path;
    private string $_query;

    private array $_options = [];

    public function __construct(
        ?string $request = null
    ) {
        if ($request)
        {
            $this->_init(
                $request
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

    public function request(
         string $address,          // URL|URI
            int $timeout   = 30,   // socket timeout, useful for offline resources
           ?int $limit     = null, // content length, null for unlimited
           ?int &$length   = 0,    // initial response length, do not change without special needs
           ?int &$code     = null, // error code for debug
        ?string &$message  = null, // error message for debug
         string &$response = ''    // response init, also returning by this method
    ): ?string
    {
        $this->_init(
            $address
        );

        $connection = stream_socket_client(
            sprintf(
                'tcp://%s:%d',
                $this->_host,
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
                "%s%s\r\n",
                $this->_path,
                $this->_query ? sprintf(
                    '?%s',
                    $this->_query
                ) : null
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


    private function _url(
        ?string $value
    ): bool
    {
        if (!$value)
        {
            return false;
        }

        if ('nex' != parse_url($value,  PHP_URL_SCHEME))
        {
            return false;
        }

        if ($host = parse_url($value,  PHP_URL_HOST))
        {
            $this->setHost(
                $host
            );
        }

        else
        {
            return false;
        }

        if ($port = parse_url($value,  PHP_URL_PORT))
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

        if ($path = parse_url($value,  PHP_URL_PATH))
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

        if ($query = parse_url($value,  PHP_URL_QUERY))
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

        return true;
    }

    private function _init(
        string $request
    ): void
    {
        if (!$this->_url($request))
        {
            if (!$this->_host || !$this->_port)
            {
                throw new \Exception();
            }
        }
    }
}
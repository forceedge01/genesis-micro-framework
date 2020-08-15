<?php

namespace Genesis\MicroFramework\Service;

class Request
{
    const TYPE_GET = 'get';

    const TYPE_POST = 'post';

    /**
     * Get a post param.
     */
    public function getPost($key, $default = null, $filter = FILTER_SANITIZE_SPECIAL_CHARS)
    {
        $value = filter_input(INPUT_POST, $key, $filter);
        if (! $value) {
            return $default;
        }

        return $value;
    }

    /**
     * Get a query param.
     */
    public function getQuery(string $key, $default = null, $filter = FILTER_SANITIZE_SPECIAL_CHARS)
    {
        $value = filter_input(INPUT_GET, $key, $filter);
        if (! $value) {
            return $default;
        }

        return $value;
    }

    /**
     * Get raw input.
     */
    public function getRaw()
    {
        return file_get_contents('php://input');
    }

    /**
     * Get raw json response as array or object.
     */
    public function getRawJson(bool $asArray = true)
    {
        return json_decode(file_get_contents('php://input'), $asArray ? true : false);
    }

    /**
     * Get a server value.
     */
    public function getServer(string $key, $default = null, $filter = FILTER_SANITIZE_SPECIAL_CHARS)
    {
        $value = filter_input(INPUT_SERVER, $key, $filter);
        if (! $value) {
            return $default;
        }

        return $value;
    }

    /**
     * Get the host name.
     */
    public function getHost(): string
    {
        return $this->getServer('HTTPS') ? 'https://' : 'http://' .
            $this->getServer('HTTP_HOST');
    }

    /**
     * Get host name without protocol to be adaptive to how the site is accessed.
     */
    public function getHostAdaptiveScheme(): string
    {
        return '//' . $this->getServer('HTTP_HOST');
    }

    /**
     * Check the method of the request.
     */
    public function isMethod(string $method): bool
    {
        return strcasecmp($this->getServer('REQUEST_METHOD'), $method) == 0;
    }
}

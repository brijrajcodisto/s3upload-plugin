<?php

namespace BaghelSoft\S3Uploads\Aws\Api\ErrorParser;

use BaghelSoft\S3Uploads\Aws\Api\Parser\JsonParser;
use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
/**
 * Parsers JSON-RPC errors.
 */
class JsonRpcErrorParser extends \BaghelSoft\S3Uploads\Aws\Api\ErrorParser\AbstractErrorParser
{
    use JsonParserTrait;
    private $parser;
    public function __construct(\BaghelSoft\S3Uploads\Aws\Api\Service $api = null, \BaghelSoft\S3Uploads\Aws\Api\Parser\JsonParser $parser = null)
    {
        parent::__construct($api);
        $this->parser = $parser ?: new \BaghelSoft\S3Uploads\Aws\Api\Parser\JsonParser();
    }
    public function __invoke(\BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface $response, \BaghelSoft\S3Uploads\Aws\CommandInterface $command = null)
    {
        $data = $this->genericHandler($response);
        // Make the casing consistent across services.
        if ($data['parsed']) {
            $data['parsed'] = array_change_key_case($data['parsed']);
        }
        if (isset($data['parsed']['__type'])) {
            $parts = explode('#', $data['parsed']['__type']);
            $data['code'] = isset($parts[1]) ? $parts[1] : $parts[0];
            $data['message'] = isset($data['parsed']['message']) ? $data['parsed']['message'] : null;
        }
        $this->populateShape($data, $response, $command);
        return $data;
    }
}

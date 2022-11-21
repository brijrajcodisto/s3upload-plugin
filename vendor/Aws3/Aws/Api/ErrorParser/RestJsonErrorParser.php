<?php

namespace BaghelSoft\S3Uploads\Aws\Api\ErrorParser;

use BaghelSoft\S3Uploads\Aws\Api\Parser\JsonParser;
use BaghelSoft\S3Uploads\Aws\Api\Service;
use BaghelSoft\S3Uploads\Aws\Api\StructureShape;
use BaghelSoft\S3Uploads\Aws\CommandInterface;
use BaghelSoft\S3Uploads\Psr\Http\Message\ResponseInterface;
/**
 * Parses JSON-REST errors.
 */
class RestJsonErrorParser extends \BaghelSoft\S3Uploads\Aws\Api\ErrorParser\AbstractErrorParser
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
        // Merge in error data from the JSON body
        if ($json = $data['parsed']) {
            $data = array_replace($data, $json);
        }
        // Correct error type from services like Amazon Glacier
        if (!empty($data['type'])) {
            $data['type'] = strtolower($data['type']);
        }
        // Retrieve the error code from services like Amazon Elastic Transcoder
        if ($code = $response->getHeaderLine('x-amzn-errortype')) {
            $colon = strpos($code, ':');
            $data['code'] = $colon ? substr($code, 0, $colon) : $code;
        }
        // Retrieve error message directly
        $data['message'] = isset($data['parsed']['message']) ? $data['parsed']['message'] : (isset($data['parsed']['Message']) ? $data['parsed']['Message'] : null);
        $this->populateShape($data, $response, $command);
        return $data;
    }
}

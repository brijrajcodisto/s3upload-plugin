<?php

namespace BaghelSoft\S3Uploads\Aws\Handler\GuzzleV6;

use Exception;
use BaghelSoft\S3Uploads\GuzzleHttp\Exception\ConnectException;
use BaghelSoft\S3Uploads\GuzzleHttp\Exception\RequestException;
use BaghelSoft\S3Uploads\GuzzleHttp\Promise;
use BaghelSoft\S3Uploads\GuzzleHttp\Client;
use BaghelSoft\S3Uploads\GuzzleHttp\ClientInterface;
use BaghelSoft\S3Uploads\GuzzleHttp\TransferStats;
use BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface as Psr7Request;
/**
 * A request handler that sends PSR-7-compatible requests with Guzzle 6.
 */
class GuzzleHandler
{
    /** @var ClientInterface */
    private $client;
    /**
     * @param ClientInterface $client
     */
    public function __construct(\BaghelSoft\S3Uploads\GuzzleHttp\ClientInterface $client = null)
    {
        $this->client = $client ?: new \BaghelSoft\S3Uploads\GuzzleHttp\Client();
    }
    /**
     * @param Psr7Request $request
     * @param array       $options
     *
     * @return Promise\Promise
     */
    public function __invoke(\BaghelSoft\S3Uploads\Psr\Http\Message\RequestInterface $request, array $options = [])
    {
        $request = $request->withHeader('User-Agent', $request->getHeaderLine('User-Agent') . ' ' . \BaghelSoft\S3Uploads\GuzzleHttp\default_user_agent());
        return $this->client->sendAsync($request, $this->parseOptions($options))->otherwise(static function ($e) {
            $error = ['exception' => $e, 'connection_error' => $e instanceof ConnectException, 'response' => null];
            if ($e instanceof RequestException && $e->getResponse()) {
                $error['response'] = $e->getResponse();
            } else {
                if (class_exists('Error') && $e instanceof \Error && $e->getResponse()) {
                    $error['response'] = $e->getResponse();
                }
            }
            return new \BaghelSoft\S3Uploads\GuzzleHttp\Promise\RejectedPromise($error);
        });
    }
    private function parseOptions(array $options)
    {
        if (isset($options['http_stats_receiver'])) {
            $fn = $options['http_stats_receiver'];
            unset($options['http_stats_receiver']);
            $prev = isset($options['on_stats']) ? $options['on_stats'] : null;
            $options['on_stats'] = static function (\BaghelSoft\S3Uploads\GuzzleHttp\TransferStats $stats) use($fn, $prev) {
                if (is_callable($prev)) {
                    $prev($stats);
                }
                $transferStats = ['total_time' => $stats->getTransferTime()];
                $transferStats += $stats->getHandlerStats();
                $fn($transferStats);
            };
        }
        return $options;
    }
}

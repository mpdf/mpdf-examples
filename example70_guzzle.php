<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;

class CustomHttpClient implements \Mpdf\Http\ClientInterface
{

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $http;

	public function __construct(Client $http)
	{
		$this->http = $http;
	}

	public function sendRequest(RequestInterface $request)
	{
		// Apply headers and other details from original request
		// Can return Guzzle response directly
		return $this->http->request($request->getMethod(), $request->getUri());
	}

}

class StdErrLogger extends \Psr\Log\AbstractLogger {
    public function log($level, $message, array $context = [])
    {
        // fwrite(STDERR, $level . ': ' . $message . "\n");
    }
}

$client = new CustomHttpClient(new Client());

$mpdf = new \Mpdf\Mpdf([], new \Mpdf\Container\SimpleContainer([
	'httpClient' => $client,
]));

$mpdf->setLogger(new StdErrLogger());

$mpdf->WriteHtml('

<p>Custom implementation of internal HTTP client using Guzzle HTTP library</p>

<img width="256" src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Neisse_bei_skerbersdorf_640x480.jpg"><br>
<img width="256" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/14-05-04-pramen-nysa-RalfR-DSC_1050-017.jpg/640px-14-05-04-pramen-nysa-RalfR-DSC_1050-017.jpg"><br>
<img width="256" src="https://upload.wikimedia.org/wikipedia/commons/e/e2/Nei%C3%9Fem%C3%BCndung.JPG">

');

$mpdf->Output();

<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

use Mpdf\Http\Response;
use Mpdf\Http\Stream;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class CustomHttpClient implements \Mpdf\Http\ClientInterface {

	public function sendRequest(RequestInterface $request)
	{
		$response = new Response();

		$stream = Stream::create(file_get_contents(__DIR__ . '/assets/tiger.jpg'));
		$stream->rewind();

		return $response
			->withStatus(200)
			->withBody($stream);
	}

};

class CustomContentLoader implements \Mpdf\File\LocalContentLoaderInterface, \Psr\Log\LoggerAwareInterface
{
	private $logger;

	public function __construct(LoggerInterface $logger = null)
	{
		$this->logger = $logger ?: new NullLogger();
	}

	public function load($path)
	{
		if (!preg_match('/alpha[0-9]{2}/', $path)) {
			$this->logger->info(sprintf('Custom local content loader ignoring path "%s"', $path));

			return base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
		}

		return file_get_contents($path);
	}

	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}
}

class StdErrLogger extends \Psr\Log\AbstractLogger {
    public function log($level, $message, array $context = [])
    {
        // fwrite(STDERR, $level . ': ' . $message . "\n");
    }
}

$client = new CustomHttpClient();
$loader = new CustomContentLoader();

$mpdf = new \Mpdf\Mpdf([], new \Mpdf\Container\SimpleContainer([
	'httpClient' => $client,
	'localContentLoader' => $loader,
]));

$mpdf->setLogger(new StdErrLogger());

$mpdf->WriteHtml('

<p>Custom implementation of internal HTTP client will return the same image of a tiger to all HTTP requests</p>

<img width="256" src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Neisse_bei_skerbersdorf_640x480.jpg"><br>
<img width="256" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/14-05-04-pramen-nysa-RalfR-DSC_1050-017.jpg/640px-14-05-04-pramen-nysa-RalfR-DSC_1050-017.jpg"><br>
<img width="256" src="https://upload.wikimedia.org/wikipedia/commons/e/e2/Nei%C3%9Fem%C3%BCndung.JPG">

<pagebreak>

<p>Custom implementation of local files loader will ignore (return an empty 1px GIF file) all files not matching regex pattern alpha[0-9]{2}</p>

<img width="256" height="256" src="assets/alpha.png"><br>
<img width="256" height="256" src="assets/alpha3.png"><br>
<img width="256" height="256" src="assets/alpha09.png"><br>
<img width="256" height="256" src="assets/alpha36.png">

');

$mpdf->Output();

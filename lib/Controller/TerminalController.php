<?php

namespace OCA\CustomProperties\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\DownloadResponse;

use Psr\Log\LoggerInterface;

class TerminalController extends Controller {

    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
     * * @param string $command
	 */
	public function exec(string $command) {
		$message = 'I am here!';
		$this->logger->error($message);
		$this->logger->warning($message);
		$this->logger->info($message);
        // $command = 'ls';
		$output = shell_exec($command);
		$result = array('result' => json_encode( $output));
		return new JSONResponse($result);
	}


}

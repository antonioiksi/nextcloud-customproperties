<?php

namespace OCA\CustomProperties\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\DownloadResponse;

use Psr\Log\LoggerInterface;

class PageController extends Controller {

    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function json() {
        $message = 'message';
        $this->logger->error($message);
        $this->logger->warning($message);
        $this->logger->info($message);
        $params = array('test' => 'hi');
        return new JSONResponse($params);
    }


    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function defaultjson() {
        $path = '/home/user/Projects/server_2/data/admin2/files/Словари/default.json';
        $this->logger->info($path);
        if(file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        }
        // $contentType = 'application/json';
        // return new DownloadResponse($path, $contentType);
    }
    
    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function xml() {
        
        echo('sdfsdfsdfsdfsdfaaaaaaaaa');
        $path = dirname(__FILE__).'/../../appinfo/info.xml';
        $this->logger->info($path);
        echo('$path');
        echo($path);
        $contentType = 'application/xml';

        return new DownloadResponse($path, $contentType);
    }

}
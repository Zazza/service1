<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 14:16
 */
namespace Controllers;

use App\Exception\UrlErrorException;
use App\JsonRPC\Client;
use App\JsonRPC\Path;
use App\Url\Url;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $url = $this->request->getPost('url');

            $Client = new Client();

            try {
                Url::urlValidate($url);

                $body = $Client->prepareRequestBody(
                    Path::URL_GENERATE,
                    ['url' => $url]
                );
                $response = $Client->sendRequest($body);
                $assign = $Client->prepareResponse($response);

                $dataResult = ['assign' => $assign];
            } catch (\Exception $e) {
                $dataResult = ['error' => $e->getMessage()];
            }

            $this->view->setVars($dataResult);
        }
    }

    public function getFromAssignAction()
    {
        if ($this->request->isPost()) {
            $assign = $this->request->getPost('assign', 'striptags', '');

            $Client = new Client();

            try {
                $body = $Client->prepareRequestBody(
                    Path::URL_GET_FROM_ASSIGN,
                    ['assign' => $assign]
                );
                $response = $Client->sendRequest($body);
                $url = $Client->prepareResponse($response);

                $dataResult = ['url' => $url];
            } catch (\Exception $e) {
                $dataResult = ['error' => $e->getMessage()];
            }

            $this->view->setVars($dataResult);
        }
    }
}

<?php
/**
 * Created by human.
 * User: Weinan Tang <twn39@163.com>
 * Date: 2018/11/15
 * Time: 下午2:56
 */
namespace App;

use Zend\Json\Server\Request;

class Auth
{
    public function check(Request $request, array $auth)
    {
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            return $this->getError($request);
        }

        $authList = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);

        if (empty($authList[1])) {
            return $this->getError($request);
        }

        $token = $authList[1];

        $now = date('Ymd');
        $data = "{$auth['algo']}-$now-{$request->getId()}-{$auth['key']}";
        $hash = hash_hmac($auth['algo'], $data, $auth['key']);

        if ($token !== $hash) {
            return $this->getError($request);
        }

        return null;
    }

    public function getError(Request $request)
    {
        header('Content-type: application/json;charset=utf-8');
        $response = new \Zend\Json\Server\Response\Http();
        $response->setId($request->getId());
        $response->setVersion('2.0');
        $response->setError(new Error('Auth required!', Error::ERROR_AUTH));
        return $response;
    }
}
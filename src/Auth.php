<?php
/**
 * Created by human.
 * User: Weinan Tang <twn39@163.com>
 * Date: 2018/11/15
 * Time: 下午2:56
 */
namespace App;

class Auth
{
    public function check()
    {
        if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
            header('Content-type: Application/json');
            $response = new \Zend\Json\Server\Response\Http();
            $response->setId('123');
            $response->setVersion('2.0');
            $response->setResult('1232');
            $response->setError(new Error('Auth required!', Error::ERROR_AUTH));
            return $response;
        }

        return null;
    }
}
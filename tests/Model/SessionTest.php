<?php
namespace Test\Model;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneratesRandomToken()
    {
        $session = $this->_mockSession();

        $session->generateToken();
        $tokenFoo = $session->getToken();

        $session->generateToken();
        $tokenBar = $session->getToken();

        $this->assertNotEquals($tokenFoo, $tokenBar);
    }

    public function testValidatesTokenWithSession()
    {
        $session = $this->_mockSession();

        $session->generateToken();
        $token = $session->getToken();
        $this->assertTrue($session->validateToken($token));
        $this->assertFalse($session->validateToken('asasdgsadg'));
    }

    public function tetsClearsTokenAfterUsage()
    {
        $session = $this->_mockSession();

        $session->generateToken();
        $session->validateToken('asasdgsadg');
        $this->assertNotNull($session->getToken());
    }

    private  function _mockSession()
    {
        return $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();
    }
}
<?php

namespace Controllers;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Controller
{
    
    protected $app;
    protected $session;
    protected $serializer;
    public function __construct($app)
    {
        $this->app = $app;
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->session = $this->app['session'];
    }
    
    protected function denyAccessWithoutLogin()
    {
    }
}

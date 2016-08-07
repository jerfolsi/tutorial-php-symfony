<?php

namespace AppBundle\Logger;

class UserLogger
{
    private $logger;

    public function __construct($logger)
    {
      //  dump($logger);
        $this->logger = $logger;
    }

    public function log($info)
    {
        //..add $entry
        $this->logger->info($info);
    }
}
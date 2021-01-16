<?php


namespace App\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionListener
{
    protected LoggerInterface $logger;
    protected KernelInterface $kernel;

    public function __construct(LoggerInterface $logger, KernelInterface $kernel)
    {
        $this->logger = $logger;
        $this->kernel = $kernel;
    }

    public function onKernelException(ExceptionEvent $event) {
        $this->logger->info("Error HANDLED " . json_encode($event->getThrowable()));
    }
}
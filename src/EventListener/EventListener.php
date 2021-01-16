<?php


namespace App\EventListener;


use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class EventListener {
    protected LoggerInterface $logger;
    protected KernelInterface $kernel;
    protected EntityManagerInterface $em;

    public function __construct(LoggerInterface $logger, KernelInterface $kernel, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->kernel = $kernel;
        $this->em = $em;
    }

    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        if($this->supports($request)) {
            $this->processEvent($event);
        } else {
            $this->logger->info($this->introduceSelf() . ' does not support this route. Skipped');
        }
    }

    protected function supports(Request $request): bool  {
        $regex = '/^' . $this->getSupportedRoutePrefix() . '_.*/';
        return preg_match($regex, $request->get('_route'));
    }

    protected abstract function processEvent(RequestEvent $event);

    protected abstract function getSupportedRoutePrefix(): string;

    protected abstract function introduceSelf(): string;

}
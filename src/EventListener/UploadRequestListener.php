<?php


namespace App\EventListener;


use App\Entity\Picture;
use App\Exception\ExceptionResolver;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class UploadRequestListener extends EventListener
{
    private FileService $fileService;
    private SerializerInterface $serializer;

    public function __construct(LoggerInterface $logger, KernelInterface $kernel, EntityManagerInterface $em, FileService $fileService, SerializerInterface $serializer)
    {
        $this->fileService = $fileService;
        $this->serializer = $serializer;
        parent::__construct($logger, $kernel, $em);
    }

    protected function processEvent(RequestEvent $event)
    {
        $this->logger->info('I will handle that request! My name is ' . self::class);
        $request = $event->getRequest();
        if($request->getMethod() == 'POST') {
            $file = $request->files->get('file');
            $error = $this->fileService->validateFile($file);
            if($error == null) {
                $request->attributes->set('file', $file);
            } else {
                $model = ExceptionResolver::resolveError($error);
                $event->setResponse(new JsonResponse(json_decode($this->serializer->serialize($model, 'json'), true), $model->getHttpCode()));
            }
        } else if($request->getMethod() == 'DELETE') {
            $id = $request->attributes->get('id');
            $picture = $this->em->getRepository(Picture::class)->findOneBy(['id' => $id]);
            $request->attributes->set('picture', $picture);
        }
    }

    protected function getSupportedRoutePrefix(): string
    {
        return 'upload';
    }

    protected function introduceSelf(): string
    {
        return self::class;
    }
}
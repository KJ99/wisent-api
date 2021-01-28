<?php


namespace App\Service;


use App\Entity\Picture;
use App\Exception\ApiException;
use App\Exception\ExceptionResolver;
use App\Result\Result;
use App\ViewModel\ResponseViewModel\DeleteResponseViewModel;
use App\ViewModel\ResponseViewModel\UploadResponseViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Kreait\Firebase\Storage;
use Kreait\Firebase\Factory;
use Psr\Log\LoggerInterface;
use Spatie\Async\Pool;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private EntityManagerInterface $em;
    private ParameterBagInterface $params;
    private LoggerInterface $logger;

    private int $maxFileSize;
    private string $uploadsDir;

    private string $defaultAvatarDir;
    private string $defaultAvatarName;


    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params, LoggerInterface $logger) {
        $this->em = $em;
        $this->params = $params;
        $this->maxFileSize = $params->get('upload_max_size_mb') * 1024 * 1024;
        $this->uploadsDir = $params->get('uploads_dir');
        $this->logger = $logger;
        $this->defaultAvatarDir = $params->get('default_avatar_dir');
        $this->defaultAvatarName = $params->get('default_avatar_name');
    }

    public function validateFile(?UploadedFile $file): ?ApiException {
        $error = null;
        if($file == null) {
            $error = new ApiException('File not found', 100, 400);
        } else if(!in_array(strtolower($file->getMimeType()), $this->getAllowedMimeTypes())) {
            $error = new ApiException('File type not allowed', 101, 400);
        } else if($file->getSize() > $this->maxFileSize) {
            $error = new ApiException('File is too large', 102, 400);
        }
        return $error;
    }

    public function getDefaultUserAvatar(): Picture {
        $picture = new Picture();
        $picture->setDirectory($this->defaultAvatarDir);
        $picture->setFileName($this->defaultAvatarName);
        $picture->setMime('image/png');
        return $picture;
    }

    public function resolveFile(UploadedFile $file): Result {
        $result = new Result();
        try {
            $picture = $this->processFile($file);
            $viewModel = new UploadResponseViewModel();
            $viewModel->setId($picture->getId());
            $viewModel->setMessage('File uploaded');
            $result->setHttpCode(201);
            $result->setViewModel($viewModel);
        } catch (\Exception $e) {
            $viewModel = ExceptionResolver::resolveError($e);
            $result->setHttpCode($viewModel->getHttpCode());
            $result->setViewModel($viewModel);
        }
        return $result;
    }

    public function deleteFile(Picture $picture): Result {
        $result = new Result();
        $pictureId = $picture->getId();
        try {
            $this->processFileDeletion($picture);
            $response = new DeleteResponseViewModel();
            $response->setId($pictureId);
            $response->setMessage('File deleted');
            $result->setHttpCode(200);
            $result->setViewModel($response);
        } catch (\Exception $e) {
            $this->logger->warning(self::class . ' caught an exception: ' . $e->getMessage() . ' details: ' . json_encode($e));
            $response = ExceptionResolver::resolveError($e);
            $result->setHttpCode($response->getHttpCode());
            $result->setViewModel($response);
        }
        return $result;
    }

    public function deleteFileAsync(Picture $picture) {
        $pool = Pool::create();
        $pool->add(function () use($picture) {
            $id = $picture->getId();
            $this->processFileDeletion($picture);
            $this->logger->info('Successfully deleted picture: ' . $id);
        })->catch(function (\Throwable $e) use($picture) {
            $this->logger->warning('Exception caught while deletin file: ' . json_encode($picture). ' Error: ' . $e->getMessage() . ' Details: ' . json_encode($e));
        });
    }

    private function processFileDeletion(Picture $picture) {
        $path = self::getFilePath($picture);
        $this->em->remove($picture);
        $this->em->flush();
        $fs = new Filesystem();
        $fs->remove($path);
    }

    public static function getFilePath(Picture $picture) {
        return $picture->getDirectory() . '/' . $picture->getFileName();
    }

    private function processFile(UploadedFile $file): Picture {
        $fileName = $this->generateFileName($file);
        $mime = $file->getMimeType();
        $file->move($this->uploadsDir, $fileName);
        $entity = new Picture();
        $entity->setFileName($fileName);
        $entity->setDirectory($this->uploadsDir);
        $entity->setMime($mime);
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    private function generateFileName(UploadedFile $file) {
        $prefix = md5(random_bytes(64));
        $postfix = md5(random_bytes(64));
        $content = md5($file->getSize() . $file->getClientOriginalName() . time());
        $ext = $file->guessExtension();
        if($ext == null) {
            $ext = $file->getClientOriginalExtension();
        }
        return md5($prefix . $content . $postfix) . '.' . $ext;

    }

    private function getAllowedMimeTypes() {
        return [
            'image/png',
            'image/jpg',
            'image/jpeg',
            'image/webm'
        ];
    }
}
<?php


namespace App\DataFactory;


use App\Entity\Subcategory;
use App\Exception\ExceptionResolver;
use App\Result\Result;
use App\ViewModel\ResponseViewModel\DeleteResponseViewModel;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class DataFactory {

    protected SerializerInterface $serializer;

    protected EntityManagerInterface $em;

    protected ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator) {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function create($viewModel): Result {
        $result = new Result();
        $entity = $this->mapRequest($this->createEntity($viewModel), $viewModel);
        $this->em->beginTransaction();
        try {
            $this->prepareCreate($entity, $viewModel);
            $this->validateEntity($entity);
            $this->em->persist($entity);
            $this->em->flush();
            $this->postCreate($entity);
            $response = $this->mapResponse($entity);
            $this->em->commit();
            $result->setViewModel($response);
            $result->setHttpCode(201);
        } catch (\Exception $e) {
            $this->em->rollback();
            $result = $this->createErrorResult($e);
        }
        return $result;
    }

    public function update($entity, $viewModel): Result {
        $result = new Result();
        $original = clone $entity;
        $entity = $this->mapRequest($entity, $viewModel);
        $this->em->beginTransaction();
        try {
            $this->prepareUpdate($original, $entity, $viewModel);
            $this->validateEntity($entity);
            $this->em->persist($entity);
            $this->em->flush();
            $this->postUpdate($original, $entity);
            $response = $this->mapResponse($entity);
            $this->em->commit();
            $result->setViewModel($response);
        } catch (\Exception $e) {
            $this->em->rollback();
            $result = $this->createErrorResult($e);
        }
        return $result;
    }

    public function delete($entity): Result {
        $result = new Result();
        $this->em->beginTransaction();
        try {
            $entityId = $entity->getId();
            $this->prepareDelete($entity);
            $this->em->remove($entity);
            $this->em->flush();
            $this->postDelete($entity);
            $response = new DeleteResponseViewModel();
            $response->setId($entityId);
            $response->setMessage($this->getDeleteMessage());
            $this->em->commit();
            $result->setViewModel($response);
        } catch (\Exception $e) {
            $this->em->rollback();
            $result = $this->createErrorResult($e);
        }
        return $result;
    }

    protected function createErrorResult(\Exception $e) {
        $viewModel = ExceptionResolver::resolveError($e);
        $result = new Result();
        $result->setHttpCode($viewModel->getHttpCode());
        $result->setViewModel($viewModel);
        return $result;
    }

    protected function prepareCreate($entity, $viewModel) {}
    protected function prepareUpdate($original, $updated, $viewModel) {}
    protected function prepareDelete($entity) {}

    protected function postCreate($entity) {}
    protected function postUpdate($original, $updated) {}
    protected function postDelete($entity) {}

    protected function mapRequest($entity, $viewModel) {
        $modelAssoc = json_decode($this->serializer->serialize($viewModel, 'json'), true);
        $entityAssoc = json_decode($this->serializer->serialize($entity, 'json'), true);
        foreach ($modelAssoc as $key => $value) {
            $entityAssoc[$key] = $value;
        }
        return $this->serializer->deserialize(json_encode($entityAssoc), $this->getEntityClass(), 'json');
    }

    protected function mapResponse($entity) {
        $json = $this->serializer->serialize($entity, 'json');
        return $this->serializer->deserialize($json, $this->getResponseClass(), 'json');
    }

    /**
     * @param $entity
     * @throws \Exception
     */
    protected function validateEntity($entity) {
        $errors = $this->validator->validate($entity);

        if($errors->count() > 0) {
            $payload = $errors[0]->getConstraint()->payload;
            $code = is_array($payload) && isset($payload['internal']) ? $payload['internal'] : 1;
            throw new \Exception($errors[0]->getMessage(), $code);
        }
    }

    protected abstract function getDeleteMessage();
    protected abstract function getEntityClass();
    protected abstract function getResponseClass();
    protected abstract function createEntity();
}
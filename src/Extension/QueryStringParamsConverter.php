<?php


namespace App\Extension;


use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use App\ViewModel\SearchViewModel\CategorySearchViewModel;

class QueryStringParamsConverter implements ParamConverterInterface
{
    private string $name = 'in_query';
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $jsonQuery = $this->serializer->serialize($request->query->all(), 'json');
        $deserialized = $this->serializer->deserialize($jsonQuery, $configuration->getClass(), 'json');
        $request->attributes->set($configuration->getName(), $deserialized);
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getConverter() == 'in_query';
    }
}
<?php


namespace App\EventListener;


use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ContactListener extends EventListener
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, LoggerInterface $logger, KernelInterface $kernel, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        parent::__construct($logger, $kernel, $em);
    }

    protected function processEvent(RequestEvent $event)
    {
        $request = $event->getRequest();
        $contact = null;
        try {
            $contact = $this->getContact($request->request->get('contact_info'));
        } catch (\Throwable $e) {
            $this->logger->warning('Could not parse contact info');
        }
        $request->attributes->set('contact', $contact);
    }

    private function getContact(array $info): Contact {
        $contact = $this->getExistingContact($info);
        if($contact == null) {
            $contact = $this->serializer->deserialize(json_encode($info), Contact::class, 'json');
        }
        return $contact;
    }

    private function getExistingContact(array $info): ?Contact {
        $contacts = $this->em->getRepository(Contact::class)->findBy([
            'email' => $info['email'],
            'phoneNumber' => $info['phone_number'],
            'name' => $info['name']
        ]);
        return count($contacts) > 0 ? $contacts[0] : null;
    }

    protected function supports(Request $request): bool
    {
        return $request->request->has('contact_info') && is_array($request->request->get('contact_info'));
    }

    protected function getSupportedRoutePrefix(): string
    {
        return '*';
    }

    protected function introduceSelf(): string
    {
        return self::class;
    }
}
<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Caracteristique;
use App\Entity\Client;
use App\Entity\Data;
use App\Entity\Event;
use App\Entity\EventDefinition;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiEventSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['createClient', EventPriorities::PRE_WRITE],
        ];
    }

    public function createClient(ViewEvent $event): void
    {
        $client = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$client instanceof Client || Request::METHOD_POST !== $method) {
            return;
        }
        foreach ($client->getDataRaw() as $key => $value) {
            $dataEntity =  $this->em->getRepository(Data::class)->findOneBy([
                'nom_data' => $key
            ]);
            if ($dataEntity) {
                $newCara = new Caracteristique();
                $newCara->setContenu($value);
                $newCara->setClient($client);
                $newCara->setData($dataEntity);
                $this->em->persist($newCara);
                $this->em->flush();
            }
        }
    }
}

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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ApiEventSubscriber implements EventSubscriberInterface
{
    private $em;
    private $mailer;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
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
            /* if (strpos($key, '_') !== false) {
                $realKey = explode("_", $key);
                $dataEntity =  $this->em->getRepository(Data::class)->findOneBy([
                    'nom_data' => $realKey[0]
                ]);
                if ($dataEntity) {
                    $cara =  $this->em->getRepository(Caracteristique::class)->findOneBy([
                        'data' => $dataEntity,
                        'client' => $client,
                    ]);
                    if ($cara == null) {
                        if ($dataEntity->getQuestion()->getType() == 'date') {
                            $dateValue = $client->getDataRaw()["birthDate_JJ"] . '-' . $client->getDataRaw()["birthDate_MM"]  . '-' . $client->getDataRaw()["birthDate_AAAA"];
                            $newCara = new Caracteristique();
                            $newCara->setContenu($dateValue);
                            $newCara->setClient($client);
                            $newCara->setData($dataEntity);
                            $this->em->persist($newCara);
                            $this->em->flush();
                        }
                    }
                }
            }*/
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
            $email = (new Email())
                ->from('tom.siatka2@gmail.com')
                ->to($client->getEmail())
                ->subject('Merci d\'avoir participé au Quiz')
                ->html('<p>Vous recevrez bientôt votre code promo !</p>');

            $this->mailer->send($email);
        }
    }
}

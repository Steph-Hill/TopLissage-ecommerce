
<?php

use App\Entity\TrustedDevice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class TrustedDeviceListener
{

private $entityManager;

public function __construct(EntityManagerInterface $entityManager)
{
    $this->entityManager = $entityManager;
}

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $administrator = $event->getAuthenticationToken()->getUser();
        
        $trustedDevice = $this->entityManager->getRepository(TrustedDevice::class)->findOneBy([
            'administrator' => $administrator,
            // Ajoutez d'autres critères de recherche si nécessaire
        ]);
        
        dd($trustedDevice);

        if ($trustedDevice) {
            $trustedDevice->setAuthenticated(true);
        } else {
            // Effectuez une authentification à deux facteurs normale
            // ...
        }
    }
}

?>
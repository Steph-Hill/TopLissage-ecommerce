<?php
namespace App\Controller;

use App\Entity\Administrator;
use App\Entity\HairSalon;
use App\Form\RegistrationFormType;
use App\Form\HairSalonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Administrator();
        $registrationForm = $this->createForm(RegistrationFormType::class, $user);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $registrationForm->get('plainPassword')->getData()
                )
            );

            // Get the form data
            $data = $registrationForm->getData();

            // Check if the hair salon condition is true
            if ($data->isConditions()) {
                $hairSalon = new HairSalon();
                $hairSalon->setName($data->getHairSalon()->getName());
                $hairSalon->setPostalAdress($data->getHairSalon()->getPostalAddress());
                $hairSalon->setPhone($data->getHairSalon()->getPhone());
                $hairSalon->setEmploye($data->getHairSalon()->getEmploye());
                $hairSalon->setChair($data->getHairSalon()->getChair());
                // Set the professional_id if needed
                // $hairSalon->setProfessionalId($data->getHairSalon()->getProfessionalId());

                $entityManager->persist($hairSalon);
                $user->setHairSalon($hairSalon);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            // Do anything else you need here, like sending an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $registrationForm->createView(),
            'form' => $registrationForm->createView(),

        ]);
    }
}

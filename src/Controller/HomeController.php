<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder,ObjectManager $manager, UserInterface $userLog =null)
    {
        if($userLog)
        {
            return $this->redirectToRoute('user_home');
        }
        $user = new User();

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(array('ROLE_USER'));
            $user->setTokens(5);
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');

        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form'   => $form->createView(),

        ]);
    }

}

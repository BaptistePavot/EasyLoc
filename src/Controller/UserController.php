<?php

namespace App\Controller;


use App\Entity\Objet;
use App\Entity\User;
use App\Form\ObjetType;
use App\Form\ObjetUpdateType;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {


        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',

        ]);
    }

    /**
     * @Route("/login", name="user_login")
     */
    public function login()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/userLendList", name="user_list_lend")
     */
    public function lendList(UserInterface $userLog =null)
    {
        if($userLog == null)
        {
            return $this->redirectToRoute('home');
        }

        $objets = $this->getUser()->getObjets();

        return $this->render('user/lendList.html.twig', [
            'controller_name' => 'UserController',
            'objets'          => $objets
        ]);

    }

    /**
     * @Route("/userAddObjet", name="user_add_objet")
     * @Route("/userUpdateObjet/{id}", name="user_update_objet")
     */
    public function formObjet(Request $request, UserInterface $userLog =null,ObjectManager $manager, Objet $objet =null)
    {
        if($userLog == null)
        {
            return $this->redirectToRoute('home');
        }


        if(!$objet)
        {
            $objet = new Objet();
        }
        else
        {
            $objet->setImage("");
        }
        $form = $this->createForm(ObjetType::class,$objet);




        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $objet->getImage();

            //uid genere
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            //Enregistrement du fichier
            $file->move('Images',$fileName);

            $objet->setImage($fileName);
            $objet->setUser($this->getUser());
            $manager->persist($objet);
            $manager->flush();
            return $this->redirectToRoute('user_list_lend');
        }
        return $this->render('user/formObjet.html.twig',[
            'controller_name'   => 'UserController',
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/userDelObjet/{id}", name="user_del_objet")
     */
    public function delObjet(Objet $objet, ObjectManager $manager)
    {
        unlink('Images/'.$objet->getImage());
        $manager->remove($objet);
        $manager->flush();
        return $this->redirectToRoute('user_list_lend');
    }
    /**
     * @Route("/userHome", name="user_home")
     */
    public function userHome(UserInterface $userLog =null)
    {
        $objet = $this->getDoctrine()->getRepository(Objet::class);
        $objet = $objet->findAll();
        if($userLog == null)
        {
            return $this->redirectToRoute('home');
        }

        return $this->render('user/home.html.twig', [
            'controller_name' => 'UserController',
            'objets'  => $objet
        ]);
    }

    /**
     * @Route("/userAccount", name="user_account")
     */
    public function account(Request $request,UserPasswordEncoderInterface $encoder,ObjectManager $manager,UserInterface $userLog =null)
    {

        if(!$userLog)
        {
            return $this->redirectToRoute('user_home');
        }
        $user = $userLog;
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');

        }
        return $this->render('user/account.html.twig', [
            'controller_name' => 'UserController',
            'form'   => $form->createView(),

        ]);
    }

    /**
     * @Route("/deconnexion", name="user_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/failure_login", name="user_failure_login")
     */
    public function failureLogin()
    {

        return $this->render('user/failureLogin.html.twig');
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {

        return md5(uniqid());
    }
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }


}

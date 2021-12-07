<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('', name: 'user_')]
class UserController extends AbstractController
{

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(), 
        ]);
    }

}

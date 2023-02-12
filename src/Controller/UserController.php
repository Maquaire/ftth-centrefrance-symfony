<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/administration/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {        
        return $this->render('user/index.html.twig', [
            'users'         => $userRepository->findAll(),
            'breadcrumb'    => 'Administration / Gestion des profils / Votre profil',
            'title'         => 'Votre profil'
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {        
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['labelButton' => 'Créer le profil']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $idManager = $_POST['user']['manager'];
            $manager = $userRepository->findOneBy(['id' => $idManager]);

            $user->setManager($manager->getLastname().' '.$manager->getFirstname());
            $user->setDepartement(implode(',', $_POST['departement_choice']));
            $user->setCreatedAt(new \DateTimeImmutable());
            switch ($user->getJob()) {
                case 'Chef De Projet':
                    $user->setRoles(["ROLES_CDP"]);
                    break;
                case 'Responsable De Production':
                    $user->setRoles(["ROLES_RGP"]);
                    break;
                case 'Conducteur De Travaux':
                    $user->setRoles(["ROLES_CDT"]);
                    break;
                case 'Superviseur De Travaux':
                    $user->setRoles(["ROLES_SDT"]);
                    break;
                case 'Technicien Télécom Optique':
                    $user->setRoles(["ROLES_TTO"]);
                    break;
                case 'Technicien De Renfort':
                    $user->setRoles(["ROLES_TDR"]);
                    break;
            }
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $longueurMax = strlen($caracteres);
            $chaineAleatoire = '';
            for ($i = 0; $i < 254; $i++)
            {
                $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
            }
            $user->setPassword($chaineAleatoire);

            $userRepository->save($user, true);


            $this->addFlash('success', 'Le profil a été crée correctement');
            return $this->redirectToRoute('app_user_new', [], Response::HTTP_SEE_OTHER);
        }

        $test_roles = $this->choiceRole();

        return $this->render('user/new.html.twig', [
            'user'          => $user,
            'form'          => $form,
            'user_roles'    => $test_roles,
            'breadcrumb'    => 'Administration / Gestion des profils / Créer un profil',
            'title'         => 'Créer un profil'
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {   
        $test_roles = $this->choiceRole();

        return $this->render('user/show.html.twig', [
            'user'          => $user,
            'user_roles'    => $test_roles,
            'breadcrumb'    => 'Administration / Gestion des profils / Votre profil',
            'title'         => 'Votre profil'
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, $id = 1): Response
    {
        $form = $this->createForm(UserType::class, $user, ['labelButton' => 'Modifier le profil']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (isset($_POST['departement_choice'])) {
                $user->setDepartement(implode(',', $_POST['departement_choice']));
            };
            
            $idManager = $_POST['user']['manager'];
            $manager = $userRepository->findOneBy(['id' => $idManager]);

            $user->setManager($manager->getLastname().' '.$manager->getFirstname());

            switch ($user->getJob()) {
                case 'Chef De Projet':
                    $user->setRoles(["ROLES_CDP"]);
                    break;
                case 'Responsable De Production':
                    $user->setRoles(["ROLES_RGP"]);
                    break;
                case 'Conducteur De Travaux':
                    $user->setRoles(["ROLES_CDT"]);
                    break;
                case 'Superviseur De Travaux':
                    $user->setRoles(["ROLES_SDT"]);
                    break;
                case 'Technicien Télécom Optique':
                    $user->setRoles(["ROLES_TTO"]);
                    break;
                case 'Technicien De Renfort':
                    $user->setRoles(["ROLES_TDR"]);
                    break;
            }

            $userRepository->save($user, true);

            $this->addFlash('success', 'La modification a été prise en compte');
            return $this->redirectToRoute("app_user_edit", ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        $test_roles = $this->choiceRole();

        return $this->render('user/edit.html.twig', [
            'user'          => $user,
            'users'         => $userRepository->findAllOrderByLastname(),
            'form'          => $form,
            'user_roles'    => $test_roles,
            'breadcrumb'    => 'Administration / Gestion des profils / Modifier un profil',
            'title'         => 'Profil'
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute("app_user_edit", ['id' => '1'], Response::HTTP_SEE_OTHER);
    }

    //** Vérifier si l'utilisateur est CDT ou RGP ou CDP */
    public function choiceRole()
    {
        
        $user_roles = $this->getUser()->getRoles();
        $test_roles = is_numeric(array_search('ROLES_CDT', $user_roles)) ? true : (is_numeric(array_search('ROLES_RGP', $user_roles)) ? true : is_numeric(array_search('ROLES_CDP', $user_roles)));

        return $test_roles;
    }
}

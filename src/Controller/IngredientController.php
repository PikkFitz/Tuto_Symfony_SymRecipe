<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * This controller display all ingredients
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'app_ingredient', methods: ['GET'])]
    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }


    /**
     * This controller display a form to add a new ingredient to the list
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/nouveau', 'ingredient.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());

            $ingredient = $form->getData();
            // dd($ingredient);

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash    // Nécessite un block "for message" dans new.html.twig pour fonctionner
            (
                'success',  //Couleur pour Bootstrap
                'Votre ingrédient a bien été ajouté !'
            );

            return $this->redirectToRoute('app_ingredient');
        }


        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/ingredient/edition/{id}', 'ingredient.edit', methods: ['GET', 'POST'])]
    public function edit(
        Ingredient $ingredient,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // dd($form->getData());

            $ingredient = $form->getData();
            // dd($ingredient);

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash    // Nécessite un block "for message" dans new.html.twig pour fonctionner
            (
                'success',  //Couleur pour Bootstrap
                'Votre ingrédient a bien été modifié !'
            );

            return $this->redirectToRoute('app_ingredient');


            $form = $this->createForm(IngredientType::class, $ingredient);

            return $this->render('pages/ingredient/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }


    #[Route('/ingredient/suppression/{id}', 'ingredient.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager, 
        Ingredient $ingredient
    ) : Response
    {
        if(!$ingredient)
        {
            $this->addFlash    // Nécessite un block "for message" dans new.html.twig pour fonctionner
            (
                'warning',  //Couleur pour Bootstrap
                'L\'ingrédient n\'a pas été trouvé !'
            );

            return $this->redirectToRoute('app_ingredient');
        }
        $manager->remove($ingredient);
        $manager->flush();

        $this->addFlash    // Nécessite un block "for message" dans new.html.twig pour fonctionner
        (
            'danger',  //Couleur pour Bootstrap
            'Votre ingrédient a bien été supprimé !'
        );

        return $this->redirectToRoute('app_ingredient');
    }



}




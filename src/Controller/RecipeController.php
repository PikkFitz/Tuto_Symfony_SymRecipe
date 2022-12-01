<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Func;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * This controller display all recipes
     *
     * @param RecipeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(
        RecipeRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $recipes = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }


    /**
     * This controller display a form to add a new recipe to the list
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/creation', 'recipe.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $manager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash    // Nécessite un block "for message" dans index.html.twig pour fonctionner
            (
                'success',  // Nom de l'alerte 
                ['info' => 'Ajout !','bonus' => "La recette \"" . $recipe->getName() . "\" a bien été ajoutée"]  // Message(s)
            );

            return $this->redirectToRoute('recipe.index');
        }

        return $this->render('pages/recipe/new.html.twig', 
        [
            'form' => $form->createView()
        ]);
    }


    #[Route('/recette/edition/{id}', 'recipe.edit', methods: ['GET', 'POST'])]
    /**
     * This controller display a form to edit a recipe of the list
     *
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // dd($form->getData());

            $recipe = $form->getData();
            // dd($ingredient);

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash    // Nécessite un block "for message" dans index.html.twig pour fonctionner
            (
                'warning',  // Nom de l'alerte 
                ['info' => 'Modification !','bonus' => "La recette \"" . $recipe->getName() . "\" a bien été modifiée"]  // Message(s)
            );

            return $this->redirectToRoute('recipe.index');


            $form = $this->createForm(RecipeType::class, $recipe);

        }

        return $this->render('pages/recipe/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    #[Route('/recette/suppression/{id}', 'recipe.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager, 
        Recipe $recipe
    ) : Response
    {
        if(!$recipe)
        {
            $this->addFlash    // Nécessite un block "for message" dans index.html.twig pour fonctionner
            (
                'warning',  //Couleur pour Bootstrap
                ['info' => 'Recette introuvable !','bonus' => "La recette n'a pas été trouvée..."]  // Message(s)
            );

            return $this->redirectToRoute('recipe.index');
        }
        
        $manager->remove($recipe);
        $manager->flush();

        $this->addFlash    // Nécessite un block "for message" dans index.html.twig pour fonctionner
        (
            'danger',  // Nom de l'alerte 
            ['info' => 'Suppression !','bonus' => "La recette \"" . $recipe->getName() . "\" a bien été supprimée"]  // Message(s)
        );

        return $this->redirectToRoute('recipe.index');
    }


}

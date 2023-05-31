<?php

namespace App\Controller;

use App\Service\AchievementService;
use App\Form\AchievementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * @Route("achievements", name="achievements_")
*/
class AchievementController extends AbstractController
{
    private $achievementService;

    public function __construct(AchievementService $achievementService) {
        $this->achievementService = $achievementService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $achievements = $this->achievementService->getAchievementsList();

        return $this->render('achievements/index.html.twig', [
            'items' => $achievements,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(AchievementType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $achievement = $this->achievementService->createAchievement($formData);

            return $this->redirectToRoute('achievements_index');
        }

        return $this->render('achievements/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Request $request, $id): Response
    {
        $item = $this->achievementService->getOneAchievement($id);

        $form = $this->createForm(AchievementType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $achievement = $this->achievementService->updateAchievement($id, $formData);

            return $this->redirectToRoute('achievements_index');
        }

        return $this->render('achievements/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Request $request, $id): Response
    {
        try {
            $this->achievementService->delete($id);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        return $this->redirectToRoute('achievements_index');
    }
}

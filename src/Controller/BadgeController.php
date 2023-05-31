<?php

namespace App\Controller;

use App\Service\BadgeService;
use App\Form\BadgeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * @Route("badges", name="badges_")
*/
class BadgeController extends AbstractController
{
    private $badgeService;

    public function __construct(BadgeService $badgeService) {
        $this->badgeService = $badgeService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $badges = $this->badgeService->getBadgesList();

        return $this->render('badges/index.html.twig', [
            'items' => $badges,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(BadgeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $badge = $this->badgeService->createBadge($formData);

            return $this->redirectToRoute('badges_index');
        }

        return $this->render('badges/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Request $request, $id): Response
    {
        $item = $this->badgeService->getOneBadge($id);

        $form = $this->createForm(BadgeType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $badge = $this->badgeService->updateBadge($id, $formData);

            return $this->redirectToRoute('badges_index');
        }

        return $this->render('badges/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Request $request, $id): Response
    {
        try {
            $this->badgeService->delete($id);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        return $this->redirectToRoute('badges_index');
    }
}

<?php

namespace App\Controller;

use App\Service\UserRankService;
use App\Form\RankType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * @Route("user-ranks", name="user_ranks_")
*/
class UserRankController extends AbstractController
{
    private $rankService;

    public function __construct(UserRankService $rankService) {
        $this->rankService = $rankService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $ranks = $this->rankService->getRanksList();

        return $this->render('ranks/index.html.twig', [
            'items' => $ranks,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(RankType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $rank = $this->rankService->createRank($formData);

            return $this->redirectToRoute('user_ranks_index');
        }

        return $this->render('ranks/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Request $request, $id): Response
    {
        $item = $this->rankService->getOneRank($id);

        $form = $this->createForm(RankType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $rank = $this->rankService->updateRank($id, $formData);

            return $this->redirectToRoute('user_ranks_index');
        }

        return $this->render('ranks/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Request $request, $id): Response
    {
        try {
            $this->rankService->delete($id);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        return $this->redirectToRoute('user_ranks_index');
    }
}

<?php

namespace App\Controller;

use App\Service\EventService;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * @Route("events", name="events_")
*/
class EventController extends AbstractController
{
    private $eventService;

    public function __construct(EventService $eventService) {
        $this->eventService = $eventService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $events = $this->eventService->getEventsList();

        return $this->render('events/index.html.twig', [
            'items' => $events,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $event = $this->eventService->createEvent($formData);

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Request $request, $id): Response
    {
        $item = $this->eventService->getOneEvent($id);

        $form = $this->createForm(EventType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $event = $this->eventService->updateEvent($id, $formData);

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Request $request, $id): Response
    {
        try {
            $this->eventService->delete($id);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        return $this->redirectToRoute('events_index');
    }
}

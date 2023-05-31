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
 * @Route("", name="homepage_")
*/
class HomepageController extends AbstractController
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

        return $this->render('homepage/index.html.twig', [
            'events' => $events,
        ]);
    }
}

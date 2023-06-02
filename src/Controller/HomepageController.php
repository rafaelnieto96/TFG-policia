<?php

namespace App\Controller;

use App\Service\NotificationService;
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
    private $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $notifications = $this->notificationService->getNotificationsList();

        return $this->render('homepage/index.html.twig', [
            'items' => $notifications,
        ]);
    }
}

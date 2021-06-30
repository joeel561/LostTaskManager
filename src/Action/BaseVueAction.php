<?php


namespace App\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BaseAction
 * @package App\Action
 */
class BaseVueAction extends AbstractController
{
    #[Route("/modules/mailing/overview",        name: "modules_mailing_overview",        methods: ["GET"])]
    #[Route("/modules/mailing/history",         name: "modules_mailing_history",         methods: ["GET"])]
    #[Route("/modules/mailing/settings",        name: "modules_mailing_settings",        methods: ["GET"])]
    #[Route("/modules/dashboard/overview",      name: "modules_dashboard_overview",      methods: ["GET"])]
    #[Route("/modules/discord/history",         name: "modules_discord_history",         methods: ["GET"])]
    #[Route("/modules/discord/manage-webhooks", name: "modules_discord_manage_webhooks", methods: ["GET"])]
    #[Route("/modules/discord/test-sending",    name: "modules_discord_test_sending",    methods: ["GET"])]
    public function renderBaseTemplate(): Response
    {
        return $this->render('base.twig');
    }
}
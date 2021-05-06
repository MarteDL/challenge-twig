<?php

namespace App\Controller;

use App\Class\Capitalize;
use App\Class\InfoLogger;
use App\Class\Master;
use App\Class\SpacesToDashes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $message = 'Your transformed message will be displayed here.';

        $form = $this->createFormBuilder()
            ->add('message', TextType::class)
            ->add('transformStyle', ChoiceType::class, ['choices' => [
                'capitalize' => new Capitalize(),
                'spaces become dashes' => new SpacesToDashes()
            ]])
            ->add('save', SubmitType::class, ['label' => 'Log message'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $logger = new InfoLogger();

            $master = new Master();
            $message = $master->messageHandler($data['message'],
                $data['transformStyle'], $logger);
        }

        return $this->render('homepage/index.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Class\Capitalize;
use App\Class\Master;
use App\Class\SpacesToDashes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $message = 'Your transformed message will be displayed here.';
        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler(__DIR__.'/info.log',
            Logger::INFO));

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

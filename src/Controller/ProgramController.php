<?php



namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProgramController extends AbstractController

{
    /**
     * @Route("/program", name="program_index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', [
                'programs' => $programs,
            ]
        );
    }

    /**
     * @Route("program/new", name="program_new")
     */
    public function new(Request $request, Slugify $slugify, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('utilisateur@exemple.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('program/newProgramEmail.html.twig',
                    ['program' => $program]
                ));

            $mailer->send($email);


            return $this->redirectToRoute('program_index');
        }
        return $this->render('program/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/program/{slug}", name="program_show")
     */
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    /**
     * @Route("/slug/{program}/season/{season}", name="program_season_show")

     */
    public function showSeason(Program $program, Season $season, Slugify $slugify):Response
    {
        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season' => $season]);

        return $this->render('program/season_show.html.twig', [
            'season' => $season,
            'program' => $program,
            'episodes' => $episodes,
          ]);
      }

    /**
     * @Route("/programSlug/{program}/season/{season}/episode/{episodeSlug}", name="program_episode_show")

     */
    public function showEpisode(Program $program, Season $season, Episode $episode, Slugify $slugify): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'season' => $season,
            'program' => $program,
            'episode' => $episode,
        ]);
    }
}
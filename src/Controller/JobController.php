<?php

namespace App\Controller;

use App\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/jobs", name="job_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }

    /**
     * Affiche un job
     * @Route("/job/{job}", name="job_show", methods={"GET"}, requirements={"job"="\d+"})
     * @param Job $job
     */
    public function show(Job $job)
    {
    }

    /**
     * Affiche le formulaire de création de job
     * @Route("/job/new", name="job_new", methods={"GET"})
     */
    public function new()
    {
    }

    /**
     * Traite la requête d'un formulaire de création de job
     * @Route("/job", name="job_create", methods={"POST"})
     */
    public function create()
    {
    }

    /**
     * Affiche le formulaire d'édition d'un job (GET)
     * Traite le formulaire d'édition d'un job (POST)
     * @Route("/job/{job}/edit", name="job_edit", methods={"GET", "POST"})
     * @param Job $job
     */
    public function edit(Job $job)
    {
    }

    /**
     * Supprime un job
     * @Route("/job/{job}", name="job_delete", methods={"DELETE"})
     * @param Job $job
     */
    public function delete(Job $job)
    {
    }
}

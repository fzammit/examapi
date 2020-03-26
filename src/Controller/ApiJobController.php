<?php

namespace App\Controller;

use App\Entity\Job;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiJobController extends AbstractController
{

    public $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/api/jobs", name="api_job_index", methods={"GET"})
     */
    public function index()
    {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();

        $data = $this->serializer->normalize($jobs, null, ['groups' => 'all_jobs']);

        $jsonContent = $this->serializer->serialize($data, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/jobs/{job}", name="api_job_one", methods={"GET"}, requirements={"job"="\d+"})
     */
    public function findOne(Job $job)
    {
        $data = $this->serializer->normalize($job, null, ['groups' => 'all_jobs']);

        $jsonContent = $this->serializer->serialize($data, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("api/jobs", name="api_job", methods={"POST"})
     */
    public function create(Request $request)
    {
        $job = new Job;
        $job->setTitle($request->request->get('title'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($job);
        $manager->flush();

        return new Response(null, 201);
    }

    /**
     * @Route("api/jobs/{job}/edit", name="api_job_patch", methods={"POST"}, requirements={"job"="\d+"})
     */
    public function update(Request $request, Job $job)
    {
        if (!empty($request->request->get('title'))) {
            $job->setTitle($request->request->get('title'));
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        return new Response(null, 202);
    }

    /**
     * @Route("api/jobs/{job}", name="api_job_delete", methods={"DELETE"}, requirements={"job"="\d+"})
     */
    public function delete(Request $request, Job $job)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($job);

        $manager->flush();

        return new Response(null, 200);
    }
}

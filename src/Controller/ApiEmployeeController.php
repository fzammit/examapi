<?php

namespace App\Controller;

use App\Entity\Employee;
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

class ApiEmployeeController extends AbstractController
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
     * @Route("/api/employees", name="api_employee_index", methods={"GET"})
     */
    public function index()
    {
        $employees = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        $data = $this->serializer->normalize($employees, null, ['groups'=> 'all_employees']);

        $jsonContent = $this->serializer->serialize($data, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/employees/{employee}", name="api_employee_findOne", methods={"GET"}, requirements={"employee"="\d+"})
     */
    public function findOne(Employee $employee)
    {
        $data = $this->serializer->normalize($employee, null, ['groups' => 'all_employees']);

        $jsonContent = $this->serializer->serialize($data, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @route("/api/employees", name="api_employee", methods={"POST"})
     */
    public function create(Request $request)
    {
        $employee = new Employee;
        $employee->setFirstname($request->request->get('firstname'));
        $employee->setLastname($request->request->get('lastname'));
        $employee->setEmployementDate($request->request->get('employement_date'));

        $job =$this->getDoctrine()->getRepository(Job::class)->find($request->request->get('job_id'));
        $employee->setJob($job);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($employee);
        $manager->flush();

        return new Response(null, 201);
    }

    /**
     * @Route("api/employees/{employee}/edit", name="api_employee_patch", methods={"POST"}, requirements={"job"="\d+"})
     */
    public function update(Request $request, Employee $employee)
    {
        if (!empty($request->request->get('firstname'))) {
            $employee->setFirstname($request->request->get('firstname'));
        }
        if (!empty($request->request->get('lastname'))) {
            $employee->setLastname($request->request->get('lastname'));
        }
        if (!empty($request->request->get('employement_date'))) {
            $employee->setEmployementDate($request->request->get('employement_date'));
        }
        if (!empty($request->request->get('job_id'))) {
            $employee->setJob($this->getDoctrine()->getRepository(Job::class)->find($request->request->get('job_id')));
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        return new Response(null, 202);
    }

    /**
     * @Route("api/employees/{employee}", name="api_employee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Employee $employee)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($employee);

        $manager->flush();

        return new Response(null,200);
    }

}

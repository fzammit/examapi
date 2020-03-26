<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employees", name="employee_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('employee/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }

    /**
     * Affiche un employee
     * @Route("/employee/{employee}", name="employee_show", methods={"GET"}, requirements={"employee"="\d+"})
     * @param Employee $employee
     */
    public function show(Employee $employee)
    {
    }

    /**
     * Affiche le formulaire de création de employee
     * @Route("/employee/new", name="employee_new", methods={"GET"})
     */
    public function new()
    {
    }

    /**
     * Traite la requête d'un formulaire de création de employee
     * @Route("/employee", name="employee_create", methods={"POST"})
     */
    public function create()
    {
    }

    /**
     * Affiche le formulaire d'édition d'un employee (GET)
     * Traite le formulaire d'édition d'un employee (POST)
     * @Route("/employee/{employee}/edit", name="employee_edit", methods={"GET", "POST"})
     * @param Employee $employee
     */
    public function edit(Employee $employee)
    {
    }

    /**
     * Supprime un employee
     * @Route("/employee/{employee}", name="employee_delete", methods={"DELETE"})
     * @param Employee $employee
     */
    public function delete(Employee $employee)
    {
    }
}

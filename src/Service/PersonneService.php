<?php

namespace App\Service;

use App\Entity\Personne;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonneService extends AbstractController{

    public function persistPersonne(Request $request, ValidatorInterface $validator){
        $entityManager = $this->getDoctrine()->getManager();

        $firstname = $request->request->get("inputNom");
        $lastname = $request->request->get("inputPrenom");
        $date = $request->request->get("inputDateNaissance");

        $Personne = new Personne();
        $Personne->setNom($firstname);
        $Personne->setPrenom($lastname);
        $Personne->setDatenaissance($date);

        $errors = $validator->validate($Personne);
        if (count($errors) > 0) {
            //return new Response((string) $errors, 400);
            return $this->render('personne/new.html.twig', ['errors' => $errors,]);
        }
        elseif(count($errors) == 0){


            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($Personne);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }
    }

}
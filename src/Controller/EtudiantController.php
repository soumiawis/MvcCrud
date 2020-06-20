<?php


namespace App\Controller;


use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController{

    /**
     * @Route("/", name="homepage")
     */
   public function home(){
      return $this->render(
                'home.html.twig'

      );

   }

    /**
     *Permet de créer un Etudiant
     *
     * @Route("/etudiant/add", name="etudiant_add")
     *
     */
   public function crateEtudiant(Request $request, EntityManagerInterface $em){
       
       $form = $this->createForm(EtudiantType::class);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $etudiant = $form->getData();

           $em->persist($etudiant);
           $em->flush();

           $this->addFlash('success','Etudiant ajouter');

           return $this->redirectToRoute('etudiant_list');
       }

       return $this->render('etudiant/add.html.twig',[
           'f' => $form->createView()
       ]);

   }

    /**
     * @Route("/etudiant", name="etudiant_list")
     */
   public function listEtudiants(EntityManagerInterface $em){

       $repo = $em->getRepository(Etudiant::class);
       return $this->render('etudiant/list.html.twig', [
           'etudiants' => $repo->findAll()
       ]);

   }
   /**
     * @Route("/etudiant/{id}/delete", name="etudiant_delete")
     */
   public function deleteEtudiants($id, EntityManagerInterface $em){

       $repo = $em->getRepository(Etudiant::class);
       $etudiant = $repo->findOneBy(['id' => $id]);
       $nom = $etudiant->getNom();

       $em->remove($etudiant);
       $em->flush();

       $this->addFlash('danger','Etudiant '.$nom.' Supprimer');
       return $this->redirectToRoute('etudiant_list');

   }


    /**
     *Permet de modifier un etudiant
     *
     * @Route("/etudiant/{id}/edit", name="etudiant_edit")
     *
     */
    public function editEtudiant($id, Request $request, EntityManagerInterface $em){

        $repo = $em->getRepository(Etudiant::class);
        $etudiant = $repo->findOneBy(['id'=>$id]);

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $etudiant = $form->getData();

            $em->persist($etudiant);
            $em->flush();

            $this->addFlash('success','Etudiant Modifier');

            return $this->redirectToRoute('etudiant_list');
        }

        return $this->render('etudiant/add.html.twig',[
            'f' => $form->createView()
        ]);

    }



}
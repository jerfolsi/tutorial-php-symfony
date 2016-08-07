<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/07/16
 * Time: 11:07
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    /**
     * @Route("/author/delete/{id}", name="deleteAuthor")
     *
     */
    public function deleteAction(Author $author, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        return new Response("Suppression réussie");
    }


    /**
     * @Route("/author/init", name="initAuthor")
     *
     */
    public function initAuthor(Request $request)
    {
        $result = "";
        $em = $this->getDoctrine()->getManager();

        $author = new Author();
        $em->persist($author);

        $author->setName("author");
        
        //-- on flush une premiere fois pour que l'ID de l'author soit généré
        $em->flush();

        $author->setName("author" . $author->getId());

        $result .= "<br/>author : ";
        $result .= $author->getName();
        
        //-- création dynamique de livres pour l'author
        for($i=0;$i<3;$i++){
            //-- create an empty new book
            $book = new Book();

            $book->setName("livre " . $i . " de " . $author->getName());
            $book->setAuthor($author);

            //-- comme on utilise la propriété cascade={"persist"} de Author
            //-- on doit impérativement ajouter le $book à l'author
            $author->addBook($book);

            $result .= "<br/> add book : " . $book->getName();
        }
        $em->flush();

        return new Response($result);
    }
}
<?php
// src/PipelineBundle/Controller/DefaultController.php
namespace PipelineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('PipelineBundle:Default:index.html.twig');
    }


    /**
     * @Route("/{catchall}", name="catchall",
     *     requirements={"catchall":".*"})
     */
    public function catchAllAction()
    {
        return $this->render('PipelineBundle:Default:catchall.html.twig');
    }

}

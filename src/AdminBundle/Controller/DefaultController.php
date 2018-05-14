<?php
/**
 * Created by PhpStorm.
 * User: gilso_nb9zlec
 * Date: 10/05/2018
 * Time: 02:03
 */

namespace App\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="admin_default")
     * @Template("@Admin/default/index.html.twig")
     */
    public function index()
    {
        // Set some html and get the service
        $html = '<h1>Sample Title</h1><p>Lorem Ipsum</p>';
        $dompdf = $this->get('dompdf');

        // Stream the pdf to the browser
        $dompdf->streamHtml($html, "document.pdf");
    }

}
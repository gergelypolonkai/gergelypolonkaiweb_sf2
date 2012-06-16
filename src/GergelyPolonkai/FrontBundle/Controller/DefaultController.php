<?php

namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
	public function homepageAction()
	{
		return $this->render('GergelyPolonkaiFrontBundle:Default:index.html.twig', array());
	}
}

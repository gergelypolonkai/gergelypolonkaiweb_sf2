<?php

namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
	public function homepageAction()
	{
		return $this->render('GergelyPolonkaiFrontBundle:Default:index.html.twig', array());
	}

	public function disclaimerAction()
	{
		return $this->render('GergelyPolonkaiFrontBundle:Default:disclaimer.html.twig', array());
	}

	public function resumeAction($_format)
	{
		if ($_format == 'pdf')
		{
			return $this->get('io_tcpdf')->quick_pdf($this->renderView('GergelyPolonkaiFrontBundle:Default:resume.html.twig', array(
				'format' => $_format,
			)));
		}
		else
		{
			return $this->render('GergelyPolonkaiFrontBundle:Default:resume.html.twig', array(
				'format' => $_format,
			));
		}
	}
}

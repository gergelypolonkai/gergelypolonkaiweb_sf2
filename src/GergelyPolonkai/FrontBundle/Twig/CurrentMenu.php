<?php
namespace GergelyPolonkai\FrontBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of CurrentMenu
 *
 * @author Gergely Polonkai
 *
 * @DI\Service
 * @DI\Tag(name="twig.extension")
 */
class CurrentMenu extends \Twig_Extension
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    private $container;

    /**
     * @DI\InjectParams({
     *     "container" = @DI\Inject("service_container")
     * })
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        $controller = $this->container->get('request')->get('_controller');
        $route = $this->container->get('request')->get('_route');

        $currentMenu = 'none';
        if (preg_match('/BlogController/', $controller)) {
            $currentMenu = 'blog';
        } elseif (preg_match('/_homepage$/', $route)) {
            $currentMenu = 'blog';
        } elseif (preg_match('/_resume$/', $route)) {
            $currentMenu = 'resume';
        } elseif (preg_match('/_about$/', $route)) {
            $currentMenu = 'about';
        }
        return array(
            'currentMenu' => $currentMenu,
        );
    }
    public function getName()
    {
        return 'gergelypolonkaifront_currentmenu';
    }
}

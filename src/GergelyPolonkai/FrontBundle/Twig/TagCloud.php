<?php
namespace GergelyPolonkai\FrontBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of tagCloud
 *
 * @author polesz
 *
 * @DI\Service
 * @DI\Tag("twig.extension")
 */
class TagCloud extends \Twig_Extension
{
    /**
     * @var Symfony\Bridge\Doctrine\RegistryInterface $doctrine
     */
    private $doctrine;

    /**
     * @DI\InjectParams()
     */
    public function __construct(RegistryInterface $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function getGlobals()
    {
        $tagCloudQuery = $this->doctrine->getEntityManager()->createQuery('SELECT t, count(tg) ct FROM GergelyPolonkaiFrontBundle:Tag t LEFT JOIN t.tagging tg GROUP BY t.id ORDER BY t.name');
        $tagCloudList = $tagCloudQuery->getResult();
        $tagCloud = array();
        foreach ($tagCloudList as $cloudElement) {
            $tag = $cloudElement[0];
            $tagCount = $cloudElement['ct'];
            $size = ($tagCount == 0) ? 0 : floor(log($tagCount, 10));
            if ($size > 5) $size = 5;
            $tagCloud[] = array('name' => $tag->getName(), 'size' => $size);
        }

        return array(
            'tagCloud' => $tagCloud,
        );
    }

    public function getName() {
        return 'gergelypolonkaifront_tagcloud';
    }
}

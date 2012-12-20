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
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    protected function orderTags($a, $b)
    {
        return strcasecmp($a['name'], $b['name']);
    }

    public function getGlobals()
    {
        $tagCloudQuery = $this->doctrine->getEntityManager()->createQuery('SELECT t, count(tg) ct FROM GergelyPolonkaiFrontBundle:Tag t LEFT JOIN t.tagging tg GROUP BY t.id ORDER BY ct DESC');
        $tagCloudList = $tagCloudQuery->getResult();
        $tagCloud = array();
        if (count($tagCloudList) > 0) {
            $tMax = $tagCloudList[0]['ct'];
            $tMin = 1;
        }
        foreach ($tagCloudList as $cloudElement) {
            $tag = $cloudElement[0];
            $tagCount = $cloudElement['ct'];
            if ($tagCount >= $tMin) {
                $size = floor((5.0 * ($tagCount - $tMin)) / ($tMax - $tMin));
                $tagCloud[] = array('name' => $tag->getName(), 'size' => $size);
            }
        }
        usort($tagCloud, array($this, 'orderTags'));

        return array(
            'tagCloud' => $tagCloud,
        );
    }

    public function getName() {
        return 'gergelypolonkaifront_tagcloud';
    }
}

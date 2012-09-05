<?php
namespace GergelyPolonkai\FrontBundle\Twig;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of RandomHeader
 *
 * @author polonkai.gergely
 *
 * @DI\Service
 * @DI\Tag("twig.extension")
 */
class RandomHeader extends \Twig_Extension
{
    /**
     * @var string $rootDir
     */
    private $rootDir;

    /**
     * @DI\InjectParams({
     *     "kernelRootDir" = @DI\Inject("%kernel.root_dir%")
     * })
     */
    public function __construct($kernelRootDir)
    {
        $this->rootDir = $kernelRootDir;
    }

    public function getGlobals()
    {
        return array(
            'random_header' => $this->randomHeader(),
        );
    }

    private function randomHeader()
    {
        $dh = opendir($this->rootDir . '/../web/bundles/gergelypolonkaifront/images');
        $files = array();
        while ($fn = readdir($dh)) {
            if (preg_match('/^header_\d+\.png/', $fn)) {
                $files[] = $fn;
            }
        }
        return $files[array_rand($files)];
    }

    public function getName() {
        return 'random_header';
    }
}

<?php
namespace GergelyPolonkai\FrontBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Routing\Router;

/**
 * Description of CodeChunk
 *
 * @author polonkai.gergely
 *
 * @DI\Service
 * @DI\Tag("twig.extension")
 */
class CodeChunk extends \Twig_Extension
{
    /**
     * @var Symfony\Bridge\Doctrine\RegistryInterface $doctrine
     */
    private $doctrine;

    /**
     *
     * @var Symfony\Component\Routing\Router $router
     */
    private $router;

    private $hiliter;

    /**
     * @DI\InjectParams({
     *     "doctrine" = @DI\Inject("doctrine"),
     *     "router"   = @DI\Inject("router"),
     *     "hiliter"  = @DI\Inject("gergely_polonkai_geshi.geshi_highlighter")
     * })
     */
    public function __construct(RegistryInterface $doctrine, Router $router, $hiliter)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->hiliter = $hiliter;
    }

    public function getFilters()
    {
        return array(
            'insert_code_chunks' => new \Twig_Filter_Method($this, 'insertCodeChunks', array('is_safe' => array('html'))),
            'remove_code_chunks' => new \Twig_Filter_Method($this, 'removeCodeChunks', array('is_safe' => array('html'))),
        );
    }

    public function insertCodeChunks($string)
    {
        $m = array();
        $chunkRepo = $this->doctrine->getRepository('GergelyPolonkaiFrontBundle:CodeChunk');

        while (
            preg_match(
                '/\\[\\$ code:([^:]+):([^ ]+) \\$\\]/i',
                    $string, $m, PREG_OFFSET_CAPTURE)
        ) {
            $start = $m[0][1];
            $fullTag = $m[0][0];
            $len = strlen($fullTag);

            $lang = strtolower($m[1][0]);
            $slug = strtolower($m[2][0]);

            $replacement = '';
            $chunk = $chunkRepo->findOneBy(array('language' => $lang, 'slug' => $slug));

            if ($chunk !== null) {
                $link = $this->router->generate('GergelyPolonkaiFrontBundle_viewCode', array('language' => $lang, 'slug' => $slug));
                $replacement = '<div class="code-chunk">
    <p class="code-title"><a href="' . $link . '">' . $chunk->getTitle() . '</a></p>
' . $this->hiliter->geshiFilter($chunk->getContent(), $lang) . "\n";
                $description = $chunk->getDescription();
                if (($description !== null) && ($description != '')) {
                    $replacement .= '    <div class="code-description">
        ' . $description . "
    </div>\n";
                }
                $replacement .= '</div>';
            }

            $string = substr_replace($string, $replacement, $start, $len);
        }

        while (
            preg_match(
                '/\\[\\$ code:([^:]+):(.+?) \\$\\]/is',
                    $string, $m, PREG_OFFSET_CAPTURE)
        ) {
            $start = $m[0][1];
            $fullTag = $m[0][0];
            $len = strlen($fullTag);

            $lang = strtolower($m[1][0]);
            $code = $m[2][0];

            $replacement = '<div class="code-chunk">' . $this->hiliter->geshiFilter($code, $lang) . '</div>';

            $string = substr_replace($string, $replacement, $start, $len);
        }

        return $string;
    }

    public function removeCodeChunks($string)
    {
        $m = array();
        $chunkRepo = $this->doctrine->getRepository('GergelyPolonkaiFrontBundle:CodeChunk');

        while (
            preg_match(
                '/\\[\\$ code:([^:]+):([^ ]+) \\$\\]/i',
                    $string, $m, PREG_OFFSET_CAPTURE)
        ) {
            $start = $m[0][1];
            $fullTag = $m[0][0];
            $len = strlen($fullTag);
            $replacement = '';

            $string = substr_replace($string, $replacement, $start, $len);
        }

        while (
            preg_match(
                '/\\[\\$ code:([^:]+):(.+?) \\$\\]/is',
                    $string, $m, PREG_OFFSET_CAPTURE)
        ) {
            $start = $m[0][1];
            $fullTag = $m[0][0];
            $len = strlen($fullTag);
            $replacement = '';

            $string = substr_replace($string, $replacement, $start, $len);
        }

        return $string;
    }

    public function getName()
    {
        return "code_chunk";
    }
}

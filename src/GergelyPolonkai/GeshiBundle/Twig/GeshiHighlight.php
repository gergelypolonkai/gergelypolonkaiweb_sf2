<?php

namespace GergelyPolonkai\GeshiBundle\Twig;

use GeSHi;

/**
 * Description of GeshiHighlight
 *
 * @author polonkai.gergely
 */
class GeshiHighlight extends \Twig_Extension
{
    /**
     *
     * @var \GeSHi $geshi
     */
    private $geshi;

    public function __construct()
    {
        $this->geshi = new GeSHi();
    }

    public function getFilters()
    {
        return array(
            'geshi_highlight' => new \Twig_Filter_Method($this, 'geshiFilter', array('is_safe' => array('html'))),
        );
    }

    public function geshiFilter($code, $lang)
    {
        $this->geshi->set_language($lang);
        $this->geshi->set_source($code);
        $this->geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
        $this->geshi->enable_keyword_links(false);
        $this->geshi->set_overall_class("code");
        $this->geshi->enable_classes();

        return $this->geshi->parse_code();
    }

    public function getName()
    {
        return 'geshi_highlighter';
    }
}

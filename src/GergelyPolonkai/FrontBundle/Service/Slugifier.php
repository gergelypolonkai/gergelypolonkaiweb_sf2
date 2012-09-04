<?php
namespace GergelyPolonkai\FrontBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of Slugifier
 *
 * @author polonkai.gergely
 *
 * @DI\Service("slugifier")
 */
class Slugifier
{
    public function slugify($string)
    {
        $string = strtolower(
                preg_replace(
                        '/^-+/',
                        '',
                        preg_replace(
                                '/-+$/',
                                '',
                                preg_replace(
                                        '/[^a-z]+/i',
                                        '-',
                                        preg_replace(
                                                '/([a-z])[":\']/i',
                                                '\1',
                                                iconv(
                                                        'UTF-8',
                                                        'ASCII//TRANSLIT',
                                                        $string
                                                    )
                                            )
                                    )
                            )
                    )
            );

        return $string;
    }
}

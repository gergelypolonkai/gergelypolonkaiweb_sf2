<?php
namespace GergelyPolonkai\FrontBundle\Service;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of CryptEncoder
 *
 * @author polonkai.gergely
 *
 * @DI\Service("gergely_polonkai_front.service.crypt_encoder")
 */
class CryptEncoder implements PasswordEncoderInterface
{
    public function encodePassword($raw, $salt)
    {
        return crypt($raw);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return (crypt($raw, $encoded) === $encoded);
    }
}

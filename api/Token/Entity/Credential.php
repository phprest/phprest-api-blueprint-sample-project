<?php namespace Api\Token\Entity;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\XmlRoot("token")
 */
class Credential
{
    /**
     * @var string
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     */
    public $password;
}

<?php namespace Api\Temperature\Entity;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as Orm;

/**
 * @Serializer\XmlRoot("temperature")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route("/temperatures", parameters = {"id" = "expr(object.id)"}, absolute = false)
 * )
 *
 * @Orm\Entity
 * @Orm\Table(name="temperatures")
 */
class Temperature
{
    /**
     * @var integer
     * @Serializer\Type("integer")
     *
     * @Assert\Range(min = 1)
     *
     * @Orm\Id()
     * @Orm\Column(type="integer", options={"unsigned"=true})
     * @Orm\GeneratedValue()
     */
    public $id;

    /**
     * @var string
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     * @Assert\Choice(choices={"celsius"}, message="It must be celsius.")
     */
    public $unit = "celsius";

    /**
     * @var integer
     * @Serializer\Type("integer")
     *
     * @Assert\NotBlank()
     * @Assert\Range(min=-100, max=100)
     *
     * @Orm\Column(type="smallint")
     */
    public $value;

    /**
     * @var \DateTime
     * @Serializer\Type("DateTime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     *
     * @Orm\Column(type="datetime")
     */
    public $created;

    /**
     * @param integer $id
     * @param integer $value
     * @param \DateTime $created
     */
    public function __construct($id = null, $value = null, \DateTime $created = null)
    {
        $this->id = $id;
        $this->value = $value;
        $this->created = $created;
    }
}

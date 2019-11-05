<?php

namespace TestAsset\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="EntityRepository")
 * @ORM\Table(name="customers", indexes={
 *      @ORM\Index(name="idx", columns="id")
 * })
 */
class Entity extends BaseEntity implements EntityInterface
{

    const SIGNUP_MODEL_CLASS = stdClass::class;
    const QUIZ_ANSWER_MODEL_CLASS = stdClass::class;

    public function __construct()
    {
        $this->prop = new stdClass;
    }

}

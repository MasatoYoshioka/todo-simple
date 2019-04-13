<?php
declare(strict_types=1);

namespace App\Domain;

use App\ValueObjects\Todo\Id;
use App\ValueObjects\Todo\Name;
use App\ValueObjects\Todo\Description;

/**
 * TodoEntity
 * 
 * @package App\Domain;
 */
class TodoEntity
{
    /** @var Id **/
    private $id;

    /** @var Name **/
    private $name;

    /** @var Description **/
    private $description;

    /**
     *  Get Id
     *
     *  @return Id;
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     *  Set Id
     *  
     *  @param Id $id
     *  @return self
     */
    public function setId(Id $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     *  Get Name
     *
     *  @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     *  Set Name
     *
     *  @param Name $name
     *  @return self
     */
    public function setName(Name $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     *  Get Description
     *
     *  @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     *  Set Description
     *
     *  @param Description $description
     *  @return self
     */
    public function setDescription(Description $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * to array
     * @return array
     */
    public function toArray(): array
    {
    }
}

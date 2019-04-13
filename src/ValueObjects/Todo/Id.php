<?php
declare(strict_types=1);

namespace App\ValueObjects\Todo;

use Ramsey\Uuid\Uuid;

/**
 * Id 
 * 
 * @package App\ValueObjects\Todo;
 */
class Id
{
    /** @var string */
    private $id;

    /**
     * newInstance
     * 
     * @return self
     */
    public function newInstance(): self
    {
        $this->id = $this->create();
        return $this;
    }

    /**
     *  natrural 
     *
     *  @return string
     */
    public function toNatural(): string
    {
        return $this->id;
    }

    /**
     *  parse
     *
     *  @param string $id
     *  @return self
     *
     */
    public function parse(string $id): self
    {
        return (new self)->setId($id);
    }

    /**
     *  set id
     *  
     *  @param string $id
     *  @return self
     */
    private function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     *  create
     *
     *  @return string
     */
    private function create(): string
    {
        return (Uuid::uuid4())->toString();
    }
}

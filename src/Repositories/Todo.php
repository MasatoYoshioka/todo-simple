<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Domain\TodoEntity;
use App\ValueObjects\Todo\Id;

/**
 * Todo Repository 
 * 
 * @package App\Repositories;
 */
class Todo
{
    /**
     * store
     * 
     * @param TodoEntity $todo
     * @return TodoEntity
     */
    public function store(TodoEntity $todo): TodoEntity
    {

    }

    /**
     * remove
     *
     * @param TodoEntity $todo
     * @return void
     */
    public function remove(TodoEntity $todo): void
    {
    }

    /**
     *  find by primary key
     *
     *  @params Id $id
     *  @return TodoEntity
     */
    public function find(Id $id): TodoEntity
    {

    }

    /**
     *  query
     *  
     *  @return TodoEntity[]
     */
    public function query(
    ): array
    {
    }
}

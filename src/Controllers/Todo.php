<?php
declare(strict_types=1);

namespace App\Controllers;

use Kayex\HttpCodes;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use \Exception;
use App\Exceptions\ValidationError;
use App\Repositories\Todo as TodoRepository;

use App\Domain\TodoEntity;
use App\ValueObjects\Todo\Id;
use App\ValueObjects\Todo\Name;
use App\ValueObjects\Todo\Description;

use App\Utils\JsonEncoder;

/**
 * Todo Controller
 * 
 * @package App\Controlers
 */
class Todo
{

    /** @var TodoRepository **/
    private $todoRepository;

    /**
     * __construct 
     * 
     * @param TodoRepository $todoRepository 
     * @return void
     */
    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     *  list todo
     *
     *  @param ServerRequestInterface $request
     *  @param ResponseInterface $response
     *
     *  @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $todoList = $this->todoRepository->query(
        );
        return $response->withStatus(HttpCodes::HTTP_OK)->withBody(JsonEncoder::encode(array_map(function(TodoEntity $todo) {
            return $todo->toArray();
        }, $todoList)));
    }

    /**
     *  show Todo
     *  @param ServerRequestInterface $request
     *  @param ResponseInterface $response
     *
     *  @return ResponseInterface
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $todo = $this->todoRepository->find($request->getAttribute('id'));

        return $response->withStatus(HttpCodes::HTTP_OK)->withBody(JsonEncoder::encode($todo->toArray()));
    }

    /**
     *  add todo 
     *
     *  @param ServerRequestInterface $request
     *  @param ResponseInterface $response
     *
     *  @return ResponseInterface
     */
    public function add(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $this->todoRepository->store(
                (new TodoEntity)
                ->setId(
                    (new Id)->newInstance()
                )->setName(
                    (new Name)->parse($request->getAttribute('name'))
                )->setDescription(
                    (new Description)->parse($request->getAttribute('description'))
                )
            );
        } catch (ValidationError $e) {
            return $response->withStatus(HttpCodes::HTTP_BAD_REQUEST)->withBody($e->getMessage());
        }
        return $response->withStatus(HttpCodes::HTTP_CREATED);
    }

    /**
     *  todo Change
     *  @param ServerRequestInterface $request
     *  @param ResponseInterface $response
     *
     *  @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $todo = $this->todoRepository->find($request->getAttribute('id'));
        if (empty($todo)) {
            return $response->withStatus(HttpCodes::HTTP_NOT_FOUND);
        }

        try {
            $this->todoRepository->store(
                $todo
                ->setName(
                    (new Name)->parse($request->getAttribute('name'))
                )->setDescription(
                    (new Description)->parse($request->getAttribute('description'))
                )
            );
        } catch (ValidationError $e) {
            return $response->withStatus(HttpCodes::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $response->withStatus(HttpCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response->withStatus(HttpCodes::HTTP_NO_CONTENT);
    }

    /**
     *  todo Remove
     *
     *  @param ServerRequestInterface $request
     *  @param ResponseInterface $response
     *
     *  @return ResponseInterface
     */
    public function remove(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $todo = $this->todoRepository->find($request->getAttribute('id'));

        if (empty($todo)) {
            return $response->withStatus(HttpCodes::HTTP_NOT_FOUND);
        }

        try {
            $this->todoRepository->remove($todo);
        } catch (ValidationError $e) {
            return $response->withStatus(HttpCodes::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $response->withStatus(HttpCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response->withStatus(HttpCodes::HTTP_NO_CONTENT);
    }
}

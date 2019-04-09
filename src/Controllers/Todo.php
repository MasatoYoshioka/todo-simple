<?php
declare(strict_types=1);

namespace App\Controlers;

use Kayex\HttpStatus;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use \Exception;
use App\Exceptions\ValidationException;
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
     *  @param Request $request
     *  @param Response $response
     *
     *  @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $todoList = $this->todoRepository->query(
        );
        return $this->response->withStatus(HttpStatus::HTTP_OK)->withParsedBody(JsonEncoder::encode(array_map(function(Todo $todo) {
            return $todo->toArray();
        }, $todoList)));
    }

    /**
     *  show Todo
     *  @param Request $request
     *  @param Response $response
     *
     *  @return Response
     */
    public function show(Request $request, Response $response): Response
    {
        $todo = $this->todoRepository->find($request->getQuery('id'));

        return $this->response->withStatus(HttpStatus::HTTP_OK)->withParsedBody(JsonEncoder::encode($todo->toArray()));
    }

    /**
     *  add todo 
     *
     *  @param Request $request
     *  @param Response $response
     *
     *  @return Response
     *  @throws ValidationException
     */
    public function add(Request $request, Response $response): Response
    {
        try {
            $this->todoRepository->store(
                (new TodoEntity)
                ->setId(
                    (new Id)->newInstance()
                )->setName(
                    (new Name)->parse($request->getPost('name'))
                )->setDescription(
                    (new Description)->parse($request->getPost('description'))
                )
            );
        } catch (ValidationException $e) {
            return $response->withStatus(HttpStatus::HTTP_BAD_REQUEST)->parseBody($e->getMessage());
        }
        return $response->withStatus(HttpStatus::Create);
    }

    /**
     *  todo Change
     *  @param Request $request
     *  @param Response $response
     *
     *  @return Response
     */
    public function update(Request $request, Response $response): Response
    {
        $todo = $this->todoRepository->find($request->getQuery('id'));
        if (empty($todo)) {
            return $response->withStatus(HttpStatus::HTTP_NOT_FOUND);
        }

        try {
            $this->todoRepository->store(
                $todo
                ->setName(
                    (new Name)->parse($request->getPost('name'))
                )->setDescription(
                    (new Description)->parse($request->getPost('description'))
                )
            );
        } catch (ValidationException $e) {
            return $response->withStatus(HttpStatus::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $response->withStatus(HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response->withStatus(HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     *  todo Remove
     *
     *  @param Request $request
     *  @param Response $response
     *
     *  @return Response
     */
    public function remove(Request $request, Response $response): Response
    {
        $todo = $this->todoRepository->find($query->getQuery('id'));

        if (empty($todo)) {
            return $response->withStatus(HttpStatus::HTTP_NOT_FOUND);
        }

        try {
            $this->todoRepository->remove($todo);
        } catch (ValidationException $e) {
            return $response->withStatus(HttpStatus::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $response->withStatus(HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response->withStatus(Http::NoContent);
    }
}

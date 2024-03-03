<?php

namespace App\Http\Controllers;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use App\Dto\User\UserDto;
use App\Contracts\ResponseContract;

class UserController extends Controller
{
    /**
     * @var \Illuminate\Database\Query\Builder $query
     */
    public BuilderContract $query;

    /**
     * @param \App\Http\Responders\JsonResponder $json
     */
    public function __construct(public ResponseContract $json)
    {
        $this->query = app(ConnectionResolverInterface::class)->table('users');
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = $this->query->paginate(request()->input('limit', 4));
        $dtoCollection = $users->getCollection()->mapInto(UserDto::class);

        return $this->json->response($dtoCollection, meta($users));
    }
}

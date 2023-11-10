<?php

namespace App\Http\Controllers\system;

use App\Constant\RetConstant;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\system\StoreUserRequest;
use App\Logics\system\UserLogic;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use function Laravel\Prompts\error;

class UserController extends Controller
{
    public function __construct(
        protected UserLogic $logic
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return succeed($this->logic->getList());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @throws ApiException
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return succeed(
            $this->logic->addUser($request),
            __R__(RetConstant::USER_ADD_SUCCESS)
        );
    }

    /**
     * 重置密码
     * @return JsonResponse
     * @throws ApiException
     */
    public function resetPassword(): JsonResponse
    {
        return succeed(
            $this->logic->resetPassword(),
            __R__(RetConstant::RESET_PASSWORD_SUCCESS)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        echo 1;
        die;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}

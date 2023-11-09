<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Logics\data\AccountTitleLogic;
use App\Http\Requests\data\StoreAccountTitleRequest;
use App\Http\Requests\data\UpdateAccountTitleRequest;
use App\Models\data\AccountTitle;
use Illuminate\Http\Request;

class AccountTitleController extends Controller
{

    public function __construct(
        protected AccountTitleLogic $logic
    )
    {

    }

    /**
     * 页面配置信息
     */
    public function pageConfig()
    {
        return succeed($this->logic->pageConfig());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return succeed($this->logic->getList($request));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreAccountTitleRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountTitleRequest $request)
    {
        # 验证
        $data = $request->validated();

        AccountTitle::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountTitle $accountTitle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountTitle $accountTitle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountTitleRequest $request, AccountTitle $accountTitle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountTitle $accountTitle)
    {
        //
    }
}

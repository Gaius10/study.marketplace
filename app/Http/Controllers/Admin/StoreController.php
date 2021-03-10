<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;

class StoreController extends Controller
{
    function __construct()
    {
        $this->middleware('user.has.store')->only(['create', 'store']);
    }

    public function index()
    {
        $store = auth()->user()->store;

        return view('admin.stores.index', compact('store'));
    }

    public function create()
    {
        $users = \App\Models\User::all(['id', 'name']);

        return view('admin.stores.create', compact('users'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $user->store()->create($data);

        flash('Loja criada com sucesso.')->success();
        return redirect()->route('admin.stores.index');
    }

    public function edit($store)
    {
        $store = \App\Models\Store::find($store);

        return view('admin.stores.edit', compact(['store']));
    }

    public function update(StoreRequest $request, $store)
    {
        $data = $request->all();

        $store = \App\Models\Store::find($store);
        $store->update($data);

        flash('Loja atualizada com sucesso.')->success();
        return redirect()->route('admin.stores.index');
    }

    public function destroy($store)
    {
        $store = \App\Models\Store::find($store);
        $store->delete();

        flash('Loja removida com sucesso.')->success();
        return redirect()->route('admin.stores.index');
    }
}

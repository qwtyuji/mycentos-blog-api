<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use Illuminate\Http\Request;

class MenuController extends AuthController
{
    protected $menu;

    /**
     * MenuController constructor.
     * @param $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = $this->menu->paginate();
        return view('admin.menu.index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => 'required',
            'url' => 'required',
        ];
        $message = [
            'name.required' => '请输入名称',
            'url.required' => '请输入链接地址',
        ];
        $this->validate($request, $rule, $message);
        $this->menu->create($request->all());
        return redirect()->route('menu.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = $this->menu->findOrFail($id);
        return view('admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = $this->menu->findOrfail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = [
            'name' => 'required',
            'url' => 'required',
        ];
        $message = [
            'name.required' => '请输入名称',
            'url.required' => '请输入链接地址',
        ];
        $this->validate($request, $rule, $message);
        $menu = $this->menu->findOrFail($id);
        $menu->update($request->all());
        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = $this->menu->findOrFail($id);
        $menu->delete();
        return redirect()->route('menu.index');
    }
}
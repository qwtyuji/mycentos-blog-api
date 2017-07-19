<?php

namespace App\Api;

use App\Link;
use Illuminate\Http\Request;

/**
 * Class LinkController
 * @package App\Api
 */
class LinkController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Link
     */
    protected $link;

    /**
     * LinkController constructor.
     * @param Request $request
     * @param Link $link
     */
    public function __construct(Request $request, Link $link)
    {
        $this->request = $request;
        $this->link = $link;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->link->where('name', 'like', '%' . $keyword . '%')
                ->paginate()->toArray();
        } else {
            $data = $this->link->orderBy('id', 'desc')->paginate()->toArray();
        }

        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = $this->link->all();
        return response()->json($data);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = $this->link->where('id', '<>', $data['id'])->where('name', $data['name'])->first();
        } else {
            $rs = $this->link->where('name', $data['name'])->first();
        }
        return $this->check($rs);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $this->validate($this->request, [
            'name' => 'required',
            'url' => 'required',
        ]);
        $data = $this->request->all();
        $this->link->create($data);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $link = $this->link->findOrFail($this->request->id);
        $link->fill($this->request->all());
        $link->save();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $link = $this->link->findOrFail($this->request->id);
        $link->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->link->destroy($ids);
        return $this->success();
    }
}
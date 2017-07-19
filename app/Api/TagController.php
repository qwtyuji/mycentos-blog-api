<?php

namespace App\Api;

use App\Tag;
use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Api
 */
class TagController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Tag
     */
    protected $tag;

    /**
     * CategorController constructor.
     * @param $requst
     */
    public function __construct(Request $request, Tag $tag)
    {
        $this->request = $request;
        $this->tag = $tag;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->tag->where('name', 'like', '%' . $keyword . '%')
                ->paginate()->toArray();
        } else {
            $data = $this->tag->orderBy('id', 'desc')->paginate()->toArray();
        }

        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = $this->tag->all();
        return response()->json($data);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = $this->tag->where('id', '<>', $data['id'])->where('name', $data['name'])->first();
        } else {
            $rs = $this->tag->where('name', $data['name'])->first();
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
        ]);
        $data = $this->request->all();
        $this->tag->create($data);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $tag = $this->tag->findOrFail($this->request->id);
        $tag->fill($this->request->all());
        $tag->save();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $tag = $this->tag->findOrFail($this->request->id);
        $tag->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->tag->destroy($ids);
        return $this->success();
    }
}
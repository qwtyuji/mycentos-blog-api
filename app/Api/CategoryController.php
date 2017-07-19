<?php

namespace App\Api;

use App\Category;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 * @package App\Api
 */
class CategoryController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Category
     */
    protected $category;

    /**
     * CategorController constructor.
     * @param $requst
     */
    public function __construct(Request $request, Category $category)
    {
        $this->request = $request;
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->category->where('name', 'like', '%' . $keyword . '%')
                ->paginate()->toArray();
        } else {
            $data = $this->category->orderBy('id', 'desc')->paginate()->toArray();
        }
        foreach ($data['data'] as $key => $v) {
            if (isset($this->category->getCateNameList()[$v['pid']])) {
                $catename = $this->category->getCateNameList()[$v['pid']];
            } else {
                $catename = "未知";
            }
            $data['data'][$key]['catename'] = $catename;
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $data = $this->category->all();
        return response()->json($data);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = $this->category->where('id', '<>', $data['id'])->where('name', $data['name'])->first();
        } else {
            $rs = $this->category->where('name', $data['name'])->first();
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
            'pid' => 'required',
        ]);
        $category = $this->request->all();
        $this->category->create($category);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $category = $this->category->findOrFail($this->request->id);
        $category->fill($this->request->all());
        $category->save();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $category = $this->category->findOrFail($this->request->id);
        $category->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids =explode(',',$this->request->ids);
        $this->category->destroy($ids);
        return $this->success();
    }
}
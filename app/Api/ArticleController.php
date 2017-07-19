<?php

namespace App\Api;

use App\Article;
use App\Events\EventLog;
use App\Tag;
use Illuminate\Http\Request;


/**
 * Class ArticleController
 * @package App\Api
 */
class ArticleController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Tag
     */
    protected $tags;

    /**
     * ArticleController constructor.
     * @param $request
     */
    public function __construct(Request $request, Tag $tags)
    {
        $this->request = $request;
        $this->tags = $tags;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = Article::where('title', 'like', '%' . $keyword . '%')
                ->orWhere('keywords', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->with('category', 'tag')->paginate();
        } else {
            $data = Article::orderBy('id', 'desc')->with('category', 'tag')->paginate();
        }

        return response()->json($data);
    }


    /**
     * 验证用户名唯一
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkName()
    {
        $data = $this->request->all();
        if (isset($data['id'])) {
            $rs = Article::where('id', '<>', $data['id'])->where('title', $data['title'])->first();
        } else {
            $rs = Article::where('title', $data['title'])->first();
        }
        return $this->check($rs);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = $this->request->all();
        $tags = $this->normalizeTags($this->request->get('tag'));
        $this->validate($this->request, [
            'title' => 'required|min:6',
            'category_id' => 'required',
        ]);

        $article = Article::create($data);
        $article->tag()->attach($tags);
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function pic()
    {

        $file = $this->request->file('file');
        if (is_null($file)){
            return $this->error('请选择图片');
        }
        $path = config('app.domain').'/uploads/' . $file->store('', 'uploads');
        return $this->success('上传成功',$path);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $article = Article::findOrFail($this->request->id);
        $data = $this->request->all();
        $tags = $this->normalizeTags($this->request->get('tag'));
        $this->validate($this->request, [
            'title' => 'required|min:6',
            'category_id' => 'required',
        ]);
        $article->update($data);
        $article->tag()->detach();
        $article->tag()->attach($tags);
        return $this->success();

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $article = Article::findOrFail($this->request->id);
        $article->delete();
        $article->tag()->detach();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $article = Article::whereIn('id', $ids)->get();
        $article->each(function ($v) {
            $v->tag()->detach();
            $v->delete();
        });
        return $this->success();
    }

    /**
     * @param array|null $tags
     * @return array
     */
    protected function normalizeTags(array $tags = null)
    {
        return collect($tags)->map(function ($tag) {
            if (is_numeric($tag)) {
                return (int)$tag;
            }
            $newTag = $this->tags->create(['name' => $tag]);
            return $newTag->id;
        })->toArray();
    }
}

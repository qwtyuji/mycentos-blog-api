<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/18-下午3:50
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Comment;
use Illuminate\Http\Request;

class CommentController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Log
     */
    protected $comment;

    /**
     * CategorController constructor.
     * @param $requst
     */
    public function __construct(Request $request, Comment $comment)
    {
        $this->request = $request;
        $this->comment = $comment;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $keyword = $this->request->keyword;
        if ($keyword) {
            $data = $this->comment->where('body', 'like', '%' . $keyword . '%')
                ->with('user','article')
                ->paginate()->toArray();
        } else {
            $data = $this->comment->with('user','article')->orderBy('id', 'desc')->paginate()->toArray();
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = $this->comment->findOrFail($this->request->id);
        $user->delete();
        return $this->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchremove()
    {
        $ids = explode(',', $this->request->ids);
        $this->comment->destroy($ids);
        return $this->success();
    }
}
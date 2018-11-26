<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\Reply;
use App\Models\User;
use App\Http\Requests\Api\ReplyRequest;
use App\Transformers\ReplyTransformer;
use App\Transformers\TopicTransformer;

class RepliesController extends Controller
{
    public function index(Topic $topic)
    {
        $replies = $topic->replies()->paginate(20);

        return $this->response->paginator($replies, new ReplyTransformer());
    }

    public function UserIndex(User $user)
    {
        $replies = $user->replies()->paginate(20);

        return $this->response->paginator($replies,new ReplyTransformer());
    }

    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->input('content');
        $reply->topic_id = $topic->id;
        $reply->user_id = $this->user()->id;
        $reply->save();

        return $this->response->item($reply, new ReplyTransformer())
            ->setStatusCode(201);
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            return $this->response->errorBadRequest();
        }

//        \Log::info($topic->user_id .'----'.$reply->user_id.'-----'.$this->user()->id);
        $this->authorize('destroy', $reply);
        $reply->delete();

        return $this->response->noContent();
    }
}
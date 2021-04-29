<?php

namespace App\Http\Livewire;

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Post as PostModel;
use App\Models\Category;


class Index extends Component
{
    public $page = 'feed';
    public $category_id = 0;
    public $post_id = 0;

    private const AUTH_ONLY_PAGE = [
        'settings',
        'edit-post',
        'my-posts',
        'favorite'
    ];

    private const PUBLIC_PAGE = [
        'feed',
        'post',
        'policy',
    ];

    protected $listeners = [
        'loadPost',
        'editPost',
        'changeCategory',
        'favoriteChange',
        'likeChange',
        'history-move' => 'historyMove',
        'change-page' => 'changePage',
    ];

    public function historyMove($params)
    {
        $this->post_id = intval($params['post'] ?? 0) ;
        $this->category_id = intval($params['category'] ?? 0);
        if ($this->post_id)
            $this->page = 'post';
        else
            $this->page = 'feed';
        $this->page = $params['page'] ?? $this->page;
    }

    public function  changePage($type = 'feed') {
        if (array_search($type, self::PUBLIC_PAGE) !== false ||
            (array_search($type, self::AUTH_ONLY_PAGE) !== false && Auth::check())
        ) {
            $this->page = $type;
        }
        else
            $this->page = 'feed';
    }

    public function favoriteChange($inFavorite, $post_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $post = PostModel::findOrFail($post_id);
            if ($inFavorite)
                $user->favorite()->detach($post);
            else
                $user->favorite()->attach($post);
        }
    }

    public function likeChange($liked, $post_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $post = PostModel::findOrFail($post_id);
            if ($liked)
                $user->liked()->detach($post);
            else
                $user->liked()->attach($post);
        }
    }

    public function changeCategory($id)
    {
        if ($id)
            Category::findOrFail($id);
        $this->post_id = 0;
        $this->page = 'feed';
        $this->category_id = $id;
        $this->emit('changePage');
    }

    public function loadPost($id)
    {
        if (!$id)
            return;
        $post = PostModel::findOrFail($id);
        $this->post_id = $id;
        $this->page = 'post';
        $this->emit('changePage');
    }

    public function editPost($id)
    {
        $post = PostModel::findOrFail($id);
        $this->post_id = $id;
        $this->page = 'edit-post';
        $this->emit('changePage');
    }

    public function mount($type ='feed')
    {
        $this->changePage($type);
    }

    public function render()
    {
        if (!$this->category_id)
            $this->category_id = intval($_GET['category'] ?? 0);
        if (!$this->post_id)
            $this->post_id = intval($_GET['post'] ?? 0) ;
        return view('livewire.index')
            ->extends('layouts.base');
    }
}

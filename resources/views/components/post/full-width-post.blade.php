<div class="post-full-width"
     onclick="history.pushState({ post: {{ $post->id }} }, '{{ $post->title }}', '?post={{ $post->id }}') ;
         Livewire.emit('loadPost', {{ $post->id }})">
    <img src="{{ $post->preview }}" class="post-preview-image">
    <div class="post-body-wrapper">
        <div class="post-body">
            <div class="post-title">{{ $post->title }}</div>
            {{ $post->synopsis }}
        </div>
        <div class="post-footer">
            <span class="font-bold text-gray-500">
                {{ $post->created_at->format('d.m.Y') }}
            </span>
            <a href="#" class="post-nickname">
                {{ ucwords($post->user->nickname) }}
            </a>
            <x-elements.post-views
                class="post-views"
                views="{{ $post->views }}"
            ></x-elements.post-views>
            <x-elements.star
                class="block ml-auto h-5"
                :inFavorite="$post->inFavorite()"
            ></x-elements.star>
        </div>
    </div>
</div>
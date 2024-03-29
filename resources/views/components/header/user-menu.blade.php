<div x-data="{open: false}" class="{{ $class ?? '' }} relative">
    <a @click="open=!open">
	<img class="user_menu shadow-filter" 
		@if(count(Auth::user()->avatar))
            src="{{ Storage::url(Auth::user()->avatar['ico']) }}"
        @else
            src="{{ '/user/avatar.png' }}"
        @endif
        >
    </a>
    <ul x-show.transition="open"
        style="display:none"
        @click.away="open=false"
        @click="open = false;"
        class="absolute z-30 text-gray-900 w-48 shadow-md right-0 rounded py-2.5 leading-8 top-14 text-green-500 bg-green-100">
        <li class="px-5 text-xl mb-1 text-black">{{ explode(' ', Auth::user()->name)[0] }}</li>
        <li class="px-5 hover:bg-green-200 cursor-pointer sm:hidden">
            <div class="w-full h-full" @mouseup="changePage('favorite');">
                {{ __('Избранное') }}
            </div>
        </li>
        <li class="px-5 hover:bg-green-200 cursor-pointer">
            <div class="w-full h-full" @mouseup="changePage('settings');">
                {{ __('Настройки') }}
            </div>
        </li>
        @if(Auth::user()->role('admin'))
            <li class="px-5 hover:bg-green-200 cursor-pointer">
                <div class="w-full h-full" @mouseup="changePage('users');">
                    {{ __('Пользователи') }}
                </div>
            </li>
        @endif
        @if(Auth::user()->role('admin', 'moderator'))
            <li class="px-5 hover:bg-green-200 cursor-pointer">
                <div class="w-full h-full" @mouseup="changePage('moderation');">
                    {{ __('Модерация') }}
                </div>
            </li>
        @endif
        <li class="px-5 hover:bg-green-200 cursor-pointer">
            <div class="w-full h-full" @mouseup="changePage('my-posts');">
                {{ __('Мои посты') }}
            </div>
        </li>
        <li class="px-5 hover:bg-green-200 cursor-pointer">
            <div class="w-full h-full" @mouseup="changePage('edit-post');">

                {{ __('Создать пост') }}
            </div>
        </li>
        <li class="px-5 hover:bg-green-200 cursor-pointer" @click="window.open('mailto:hheimerd@yandex.ru')">
            <div class="w-full h-full">
                {{ __('Помощь') }}
            </div>
        </li>
        <li class="px-5 hover:bg-green-200 cursor-pointer" @click="location.href = '{{ route('logout') }}'">
            <div class="w-full h-full">
                {{ __('Выйти') }}
            </div>
        </li>
    </ul>
</div>

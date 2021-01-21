<header class="shadow-md fixed top-0 z-20 h-12 pt-1 {{ $class ?? '' }}">
    <div id="header_wrapper" class="w-5/6  xl:w-2/3 mx-auto px-4 sm:px-6 ">
        <div class="flex w-full justify-between items-center md:space-x-10">
            <a href="/" id="logo" class="text-4xl w-1/6">Mint</a>
            <livewire:search class="w-7/12 md:w-5/12" />
            <div id="user_bar" class="justify-between space-x-2.5 pl-4 w-1/4 hidden sm:flex">
                <img class="user_menu shadow-filter " src="/ico/inFavorite.svg">
                <x-header.notifications></x-header.notifications>
                <x-header.user-menu></x-header.user-menu>
                <span class="text-xl my-auto hidden lg:block">Константин</span>
            </div>
        </div>
    </div>
</header>
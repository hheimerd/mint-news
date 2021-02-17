<div class="w-full bg-green-100 rounded py-4 px-8 post-wrapper relative"
     x-data="{
            image: null,
            error: '',
            validate() {
                if (!this.$refs.preview.value.length) {
                    this.error = '{{ __('Этому посту не хватает красивого изображения. Мокки любит картинки!') }}'
                    return false;
                }
                let content = document.getElementById('editor');
                if (content.innerText.length < 400) {
                    this.error = '{{ __('Этот пост слишком короткий, Мокки такое не одобрит 😟') }}'
                    return false;
                }
                if (content.innerText.length > 16000) {
                    this.error = '{{ __('Этот пост слишком длинный, Мокки такое не одобрит 😟') }}'
                    return false;
                }
                return true;
            },
            sendData(e) {
                if (!this.validate(e))
                    return false;
                let formData = new FormData(e.target);
                let content = document.getElementById('editor');
                formData.append('body', content.innerHTML);
                axios.post('{{ route('posts.store')  }}', formData)
                    .then((response) => {
                        console.log('success');
                        location.href = '/';
                    })
                    .catch((error) => {
                        console.log(error.response);
                        alert('{{ __('Произошла ошибка загрузки') }}');
                    })
            }
        }"
     @change-page.prevent="console.log"
>
    <form class="flex flex-col" x-ref="postForm" @submit.prevent="sendData">
        @csrf
        <div x-show="error.length"
             x-ref="errorMessage"
             @scroll.window="$refs.errorMessage.style.top = document.scrollHeight + 'px'"
            class="absolute top-72 w-full left-0 z-10"
        >
            <div
                 class="rounded m-auto cursor-pointer left-0 right-0 p-3 w-80 mx-auto text-center px-10 bg-green-500 text-green-100 font-medium"
                 x-text="error"
                 @click.window="error = ''"
            ></div>
        </div>

        <div class="pr-2" contenteditable="true">
            <textarea name="title"
                      maxlength="80"
                      minlength="20"
                      required
                      @input="$event.target.style.height = 'auto'; $event.target.style.height = $event.target.scrollHeight - 25 + 'px'"
                      placeholder="{{ __('Заголовок') }}"
                      @keydown.enter.prevent=""
                      class="transparent-textarea w-full h-10 text-2xl font-bold"></textarea>
        </div>
        <div class="flex space-x-2 my-3">
            <div class="text-green-500">
                {{ ucfirst(Auth::User()->nickname) }}
            </div>
            <div class="font-medium">
                {{  now()->format('d.m.Y') }}
            </div>
        </div>
        <div class="h-96 my-3 relative cursor-pointer bg-photo rounded"
             :class="{ 'border' : !image }"
             @click="$refs.preview.click()"
        >
            <template x-if="image">
                <img class="post-image rounded object-cover h-full w-full"
                     :src="image">
            </template>
            <div :class="{ 'invisible': image }">
                <img
                        class="absolute h-1/2 w-1/2 top-1/4 left-1/4"
                        src="/ico/photo-bg.svg"
                        alt="{{ __('Загрузите превью') }}"
                >
                <input type="file"
                       x-ref="preview"
                       name="preview"
                       accept="image/*"
                       class="h-full w-full invisible"
                       @change="image = URL.createObjectURL($event.target.files[0])"
                >
            </div>
            <div
                    x-show="image"
                    class="rounded-full w-7 h-7 bg-red-500 cursor-pointer  text-xl text-center text-white absolute top-2 right-2"
                    @click.stop="$refs.preview.value = ''; image = null"
            >
                x
            </div>
        </div>

        <textarea name="synopsis"
                  minlength="20"
                  required
                  @keydown.enter.prevent=""
                  @input="$event.target.style.height = 'auto'; $event.target.style.height = $event.target.scrollHeight - 22 + 'px'"
                  maxlength="160"
                  placeholder="{{ __('Краткое содержание') }}"
                  class="transparent-textarea font-medium"
        ></textarea>
        <div id="editor" class="max-w-full break-all"></div>
        <hr class="post-hr">
        <h2> Категории </h2>
        <select name="categories[]" required class="rounded shadow-inner bg-transparent" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button class="send-button mt-2">
            {{ __('Отправить') }}
        </button>
    </form>
    <script>
      let script = document.querySelector('script[src="/js/ckeditor.js"]');
      if (!script) {
        script = document.createElement('script');
        script.src = "/js/ckeditor.js";
        document.body.appendChild(script);
        script.onload = () => {
          const watchdog = new CKSource.Watchdog();
          window.watchdog = watchdog;

          watchdog.setCreator((element, config) => {
            return CKSource.Editor
                .create(element, config)
                .then(editor => {
                  return editor;
                })
          });

          watchdog
              .create(document.querySelector('#editor'), {
                toolbar: {
                  items: [
                    'heading',
                    'bold',
                    'link',
                    'removeFormat',
                    'indent',
                    'outdent'
                  ]
                },
                language: 'ru',
                blockToolbar: [
                  'imageUpload',
                  // 'CKFinder',
                  'blockQuote',
                  'numberedList',
                  'bulletedList',
                  'horizontalLine'
                ],


                licenseKey: '',

              })
              .catch(handleError);

          watchdog.setDestructor(editor => {
            return editor.destroy();
          });


          watchdog.on('error', handleError);

          function handleError(error) {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: 4naf563l1q99-136f1xuje08d');
            console.error(error);
          }
        }
      } else {
        watchdog
            .create(document.querySelector('#editor'))
            .catch(error => {
              console.error(error);
            });
      }


    </script>
</div>




@push('scripts')

@endpush

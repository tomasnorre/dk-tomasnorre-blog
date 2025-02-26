<div class="flex flex-col mb-4">
    <div>
        <img src="{{ $post->cover_image }}" class="rounded-2xl h-64 w-full"  alt="{{ $post->cover_alt }}"/>
    </div>
    <date class="text-gray-700 font-medium my-2">
        {{ $post->getDate()->format('F j, Y') }}
    </date>

    <h2 class="text-3xl mt-0">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="text-gray-900 font-extrabold"
        >{{ $post->title }}</a>
    </h2>

    <p class="mb-4 mt-0">{!! $post->getExcerpt(200) !!}</p>

    <a
        href="{{ $post->getUrl() }}"
        title="Read more - {{ $post->title }}"
        class="uppercase font-semibold tracking-wide mb-2"
    >Read</a>
</div>

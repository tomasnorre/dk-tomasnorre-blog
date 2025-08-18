<div class="bg-bg rounded-2xl shadow-md overflow-hidden flex flex-col">
    <img src="{{ $post->cover_image }}" alt="{{ $post->cover_alt }}" class="w-full h-48 object-cover" />

    <!-- Make the inner content grow with flex -->
    <div class="p-6 flex flex-col flex-1">
        <p class="text-sm text-text mb-1">
            {{ $post->getDate()->format('F j, Y') }}
        </p>

        <a href="{{ $post->getUrl() }}" title="Read more - {{ $post->title }}">
            <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
            <p class="mb-4 text-text">{!! $post->getExcerpt(200) !!}</p>
        </a>

        <!-- Spacer + Read More -->
        <div class="mt-auto pt-4">
            <a href="{{ $post->getUrl() }}" title="Read more - {{ $post->title }}"
               class="text-link font-semibold hover:underline">Read More →</a>
        </div>
    </div>
</div>

@props([
    'image',
    'title',
    'subtitle' => '',
])

<div
    class="relative overflow-hidden hidden sm:block"
    style="width: 100vw; margin-left: calc(50% - 50vw); height: 30vh;"
    x-data="{ offset: 0 }"
    x-init="
        const update = () => offset = window.scrollY * 0.4;
        window.addEventListener('scroll', update, { passive: true });
        update();
    "
>
    <div
        class="absolute bg-center bg-cover"
        style="top: -40%; bottom: -40%; left: 0; right: 0; filter: blur(3px); background-image: url('{{ $image }}');"
        :style="{ transform: 'translateY(' + offset + 'px)' }"
    ></div>

    {{-- Dark overlay --}}
    <div class="absolute inset-0 bg-black/50"></div>

    {{-- Content --}}
    <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 h-full">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white drop-shadow-lg mb-4">
            {{ $title }}
        </h1>
        @if($subtitle)
            <p class="text-lg sm:text-xl text-white/80 max-w-2xl drop-shadow">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</div>

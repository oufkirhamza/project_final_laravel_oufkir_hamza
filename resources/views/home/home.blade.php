@extends('layouts.index')
@section('content')
    <div>
        <div class="hero_home">
            <div class="bg-[#0a1f4696] w-full flex justify-center items-center h-[50vh]">
                <form action="{{ route('search') }}" method="GET">
                    <div class="flex w-[50%] mx-10 rounded bg-white">
                        <input class=" w-full border-none bg-transparent px-4 py-1 outline-none focus:outline-none "
                            type="search" name="search" placeholder="Search..." />

                        <button type="submit" class="m-2 rounded bg-blue-600 px-4 py-2 text-white">
                            <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                                xml:space="preserve" width="512px" height="512px">
                                <path
                                    d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-4 py-2 ">
        @foreach ($properties as $propertie)
            <div class="w-[25%] py-3 rounded-lg bg-gray-400">
                <main class="grid ">
                    <div x-data="imageSlider"
                        class="relative mx-auto max-w-2xl overflow-hidden rounded-md bg-gray-100 p-2 sm:p-4">
                        <div
                            class="absolute right-5 top-5 z-10 rounded-full bg-gray-600 px-2 text-center text-sm text-white">
                            <span x-text="currentIndex"></span>/<span x-text="images.length"></span>
                        </div>

                        <button @click="previous()"
                            class="absolute left-5 top-1/2 z-10 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-md">
                            <i class="fas fa-chevron-left font-bold text-gray-500"></i>
                        </button>

                        <button @click="forward()"
                            class="absolute right-5 top-1/2 z-10 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-md">
                            <i class="fas fa-chevron-right  font-bold text-gray-500"></i>
                        </button>

                        <div class="relative h-52" style="width: 20rem">
                            <template x-for="(image, index) in images">
                                <div x-show="currentIndex == index + 1"
                                    x-transition:enter="transition transform duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition transform duration-300"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="absolute top-0">
                                    <img :src="image" alt="image" class="rounded-sm" />
                                </div>
                            </template>
                        </div>
                    </div>
                </main>

                <script>
                    document.addEventListener("alpine:init", () => {
                        Alpine.data("imageSlider", () => ({
                            currentIndex: 1,
                            images: [
                                // @php
                                    //     $images = json_decode($propertie->image);
                                    //
                                @endphp
                                @foreach ($propertie->images as $image)
                                    "{{ asset('storage/img/' . $image->image) }}",
                                @endforeach
                            ],
                            previous() {
                                if (this.currentIndex > 1) {
                                    this.currentIndex = this.currentIndex - 1;
                                }
                            },
                            forward() {
                                if (this.currentIndex < this.images.length) {
                                    this.currentIndex = this.currentIndex + 1;
                                }
                            },
                        }));
                    });
                </script>
                <div onclick="window.location.href = '{{ route('propertie.show', $propertie) }}'"
                    class="px-4  cursor-pointer">
                    <div class="flex justify-between items-center  cursor-pointer">
                        <h1 class="text-2xl font-bold">{{ $propertie->title }}</h1>
                        <h1><i class="fa-solid fa-star"></i> 3,5</h1>
                    </div>
                    <p>{{ $propertie->description }}</p>
                    <p>{{ $propertie->location }}</p>
                    <span> {{ $propertie->max_guest }} member</span>
                    <h5>{{ $propertie->price_per_night }}$</h5>
                    {{-- <div>
                        @dump($propertie->images)
                        @foreach ($propertie->images as $image)
                            <img src="{{ asset('storage/img/' . $image->image) }}" alt="">
                        @endforeach
                    </div> --}}
                </div>

            </div>
        @endforeach
        <div class="bg-orange-400 w-full flex flex-col justify-center items-center py-2">
            <h1 class="text-2xl font-bold">How It Works</h1>
            <p class="text-xl">Follow these 3 steps to book your place</p>
            <div class="flex gap-5 justify-center items-center">
                <div class="flex items-center my-4 bg-white flex-col justify-center w-[25%] text-center rounded-lg p-4 ">
                    <div class="w-20 h-20 bg-purple-600 rounded-full flex justify-center items-center text-white text-2xl">
                        <i class="fa-regular fa-map"></i></div>
                    <div class="ml-4">
                        <h1 class="font-bold">01. Search for Location</h1>
                        <p>Explore various locations and find the perfect place for your stay.</p>
                    </div>
                </div>
                <div class="flex items-center my-4 bg-white flex-col justify-center w-[25%] text-center rounded-lg p-4 ">
                    <div class="w-20 h-20 bg-purple-600 rounded-full flex justify-center items-center text-white text-2xl">
                        <i class="fa-regular fa-calendar"></i></div>
                    <div class="ml-4">
                        <h1 class="font-bold">02. Select Dates</h1>
                        <p>Choose your desired check-in and check-out dates.</p>
                    </div>
                </div>
                <div class="flex items-center my-4 bg-white flex-col justify-center w-[25%] text-center rounded-lg p-4 ">
                    <div class="w-20 h-20 bg-purple-600 rounded-full flex justify-center items-center text-white text-2xl">
                        <i class="fa-regular fa-handshake"></i></div>
                    <div class="ml-4">
                        <h1 class="font-bold">03. Confirm Booking</h1>
                        <p>Complete your booking and enjoy your stay!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="to-blue-600 flex">
            <div>
                <h1>Explore Property Type</h1>
                <p>description</p>
            </div>
            <div>
                <div class="bg-white w-[20%] ">
                    <h1><i class="fa-solid fa-house"></i></h1>
                    <h1>Houses</h1>
                    <p>30 properties</p>
                </div>
            </div>
        </div>


    </div>
@endsection

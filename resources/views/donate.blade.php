@extends('layouts.master')

@section('title', "Donate")

@section('master-content')
    <nav class="bg-black shadow mb-8 py-1 h-20">
        <div class="container xl:max-w-6xl mx-auto px-6 md:px-0">
            <div class="flex items-center relative">
                <div class="mr-6 absolute top-0 left-0">
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        <img class="h-26" src="{{ asset('img/logo.png') }}" alt="WWF Logo"> </a>
                </div>

            </div>
        </div>
    </nav>

    <main class="pb-10">
        <section>
            <h1 class="mt-20 mb-5 text-3xl text-gray-800 tracking-tight font-bold uppercase text-center">More ways to give</h1>

            <div class="grid grid-cols-3 gap-4 container px-2 md:px-8 mx-auto">
                @foreach($options as $option)
                    <div class="bg-white shadow-md flex flex-col">
                        <div class="h-64 flex-shrink-0">
                            <img class="w-full h-full object-center object-cover" src="{{ $option['image_url'] }}" alt="">
                        </div>
                        <div class="px-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="mt-10 mb-5 uppercase font-bold text-xl text-gray-800 text-center">{{ $option['title'] }}</h2>
                                <p class="text-base text-center leading-normal">{{ $option['description'] }}</p>
                            </div>
                            <button class="block w-full my-5 px-4 py-4 uppercase font-semibold text-white text-base bg-orange-500 hover:bg-orange-600 transition ease-in-out duration-150">{{ $option['button_text'] }}</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mt-10 container mx-auto px-8">
            <div class="bg-white px-4 py-8 shadow">
                <h2 class="text-gray-800 font-semibold text-2xl mb-5 capitalize">Panda made me do it</h2>
                <form action="#" method="post">
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label>
                                <span class="block mb-2">First Name</span>
                                <input type="text" class="form-input w-full" required>
                            </label>
                        </div>
                        <div>
                            <label class="">
                                <span class="block mb-2">Last Name</span>
                                <input type="text" class="form-input w-full" required>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label>
                                <span class="block mb-2">Email Address</span>
                                <input type="email" class="form-input w-full" required>
                            </label>
                        </div>
                        <div>
                            <label class="">
                                <span class="block mb-2">Phone Number</span>
                                <input type="text" class="form-input w-full" required>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-8">
                        <div>
                            <label>
                                <span class="block mb-2">City</span>
                                <input type="text" class="form-input w-full" required>
                            </label>
                        </div>
                        <div>
                            <label class="">
                                <span class="block mb-2">Country</span>
                                <input type="text" class="form-input w-full" required>
                            </label>
                        </div>
                        <div>
                            <label class="">
                                <span class="block mb-2">Postal Code</span>
                                <input type="text" class="form-input w-full" required>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label>
                                <span class="block mb-2">Amount</span>
                                <input type="number" min="1" class="form-input w-full" required>
                            </label>
                        </div>
                        <div>
                            <label class="">
                                <span class="block mb-2">Payment Cycle</span>
                                <select name="payment_cycle" class="form-select w-full">
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="annually">Annually</option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="my-5 px-4 py-3 uppercase font-semibold text-white text-base bg-orange-500 hover:bg-orange-600 transition ease-in-out duration-150">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

@endsection

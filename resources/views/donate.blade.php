@extends('layouts.master')

@section('title', "Donate")

@section('master-content')
    <main class="pb-10">
        <section class="container px-2 md:px-8 mx-auto">
            <h1 class="mt-20 mb-5 text-3xl text-gray-800 tracking-tight font-bold uppercase text-center">More ways to give</h1>

            <div class="grid grid-cols-3 gap-4">
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
                            <a href="{{ $option['button_url'] }}" class="block w-full my-5 px-4 py-4 uppercase font-semibold text-center text-white text-base bg-orange-400 hover:bg-orange-600 transition ease-in-out duration-150">{{ $option['button_text'] }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mt-10 container mx-auto px-2 md:px-8 ">
            <div class="bg-white grid grid-cols-3 shadow">
                <div class="relative bg-cover bg-center bg-no-repeat" style="background: url('{{ asset('img/cute-panda.jpeg') }}'); ">
                    <div class="bg-black opacity-25 absolute inset-0"></div>
                </div>
                <div class="px-12 py-8 col-span-2">
                    <h2 class="text-gray-800 font-semibold text-2xl mb-5 capitalize">Panda made me do it</h2>
                    <form action="{{ route('subscription.store') }}" method="post">
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-inputs.input-with-label name="first_name" labelText="First Name" placeholder="James" required/>
                            </div>
                            <div>
                                <x-inputs.input-with-label name="last_name" labelText="Last Name" placeholder="Maina" required/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-inputs.input-with-label name="email" labelText="Email" placeholder="e.g. james@example.org" required/>
                            </div>
                            <div>
                                <x-inputs.input-with-label name="phone_number" labelText="Phone Number" placeholder="e.g. 25472312890" required/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-inputs.input-with-label name="city" labelText="City" placeholder="e.g. Nairobi" required/>
                            </div>
                            <div>
                                <x-inputs.input-with-label name="country" labelText="Country" placeholder="e.g. Kenya" required/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div>
                                <x-inputs.input-with-label name="postal_code" labelText="Postal Code" placeholder="e.g. 00101" required />
                            </div>

                            <div>
                                <label for="amount" class="block text-sm leading-5 font-medium text-gray-700">Amount / Cycle</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                      <span class="text-gray-500 sm:text-sm sm:leading-5">
                                        KES
                                      </span>
                                    </div>
                                    <input id="amount" class="form-input block w-full pl-11 pr-12 sm:text-sm sm:leading-5" placeholder="0.00"/>
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <select name="payment_cycle" aria-label="Payment Cycle" class="form-select h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm sm:leading-5">
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="annually">Annually</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <button type="submit" class="py-2 px-4 uppercase font-semibold text-white bg-orange-400 border border-transparent hover:bg-orange-600 transition ease-in-out duration-150">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

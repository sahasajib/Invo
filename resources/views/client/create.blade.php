<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Clients') }}
            </h2>
            <a href="{{route('client.index')}}" class="border border-green-400 px-3 py-1">{{ __('Back')}}</a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('client.store')}}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="name" class="formLabel">Name</label>
                                <input type="text" name="name" id="name" class="formInput" value="{{old('name')}}">

                                @error('name')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 ml-4">
                                <label for="username" class="formLabel">User Name</label>
                                <input type="text" name="username" id="username" class="formInput" value="{{old('username')}}">

                                @error('username')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="email" class="formLabel">Email</label>
                                <input type="text" name="email" id="email" class="formInput" value="{{old('email')}}">

                                @error('email')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 ml-4">
                                <label for="phone" class="formLabel">Phone</label>
                                <input type="text" name="phone" id="phone" class="formInput" value="{{old('phone')}}">

                                @error('phone')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="country" class="formLabel">Country</label>
                                {{-- <input type="text" id="country" class="formInput" name="country" value="{{old('country')}}"> --}}
                                <select name="country" id="country" class="formInput">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as  $country)
                                      <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>

                                @error('country')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 ml-4">
                                <label for="status" class="formLabel">Status</label>
                                <select name="status" name="status" id="status" class="formInput">
                                    <option value="active" {{old('status')== 'active'? 'seleceted':''}}>Active</option>
                                    <option value="inactive" {{old('status')== 'inactive'? 'seleceted':''}}>Inactive</option>
                                </select>

                                @error('status')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="mt-6">
                            <label for="">Thumbnail</label>
                            <label for="thumbnail"  class="formLabel border-2 rounded-md border-dashed
                            border-emerald-700 py-4 text-center">Click to upload image</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="formInput hidden">

                            @error('thumbnail')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-3 py-1 text-base bg-emerald-400
                             text-white rounded-md uppercase">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

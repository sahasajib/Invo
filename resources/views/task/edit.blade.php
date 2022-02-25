<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Tasks') }}
            </h2>
            <a href="{{route('task.index')}}" class="border border-green-400 px-3 py-1">{{ __('Back')}}</a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('task.update',$task->id)}}" method="POST" >
                        @csrf
                        @method('PUT')
                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="name" class="formLabel">Name</label>
                                <input type="text" name="name" id="name" class="formInput" value="{{$task->name}}">

                                @error('name')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mt-6">
                            <div class="flex-1 mr-4">
                                <label for="price" class="formLabel">Price</label>
                                <input type="number" name="price" id="price" class="formInput" value="{{$task->price}}">

                                @error('price')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex-1 ml-4">
                                <label for="client_id" class="formLabel">Client Name</label>
                                <select name="client_id" id="client_id">
                                    <option value="none">Select Client</option>
                                    @foreach ($clients as $client)
                                    <option value="{{$client->id}}" {{$client->id == $task->client_id ?'selected':''}}>{{$client->name}}</option>

                                    @endforeach
                                </select>

                                @error('client_id')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex mt-6 justify-between">
                            <div class="flex-1">
                                <label for="description" class="formLabel">Description</label>
                                <textarea name="description" id="description" rows="10">
                                    {{$task->description}}
                                </textarea>

                                @error('description')
                                <p class="bg-red-100 text-red-500 px-2 mt-2 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
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

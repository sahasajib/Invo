<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Clients') }}
            </h2>
            <a href="{{route('client.create')}}" class="border border-green-400 px-3 py-1">{{__('Add New')}}</a>
        </div>

    </x-slot>

    @if (Session('success'))
    <div class="py-2 bg-emerald-300 text-emerald-700 text-center" id="status_message">
        <p>{{Session('success')}}</p>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-32  text-center">Image</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2">Username</th>
                                <th class="border py-2">Email</th>
                                <th class="border py-2">Phone</th>
                                <th class="border py-2">Country</th>
                                <th class="border py-2">Task Count</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                function getImageURL($image){
                                    if(str_starts_with($image,'http')){
                                        return $image;
                                    }
                                    return asset('/uploads') .'/'. $image;
                                }
                            @endphp
                            @foreach ($clients as $client)
                            <tr>
                                <td class="border py-2 w-32 text-center">
                                    <img src="{{getImageUrl($client->thumbnail)}}" width="50" class="mx-auto rounded" alt="">
                                </td>
                                <td class="border py-2 text-center">{{$client->name}}</td>
                                <td class="border py-2 text-center">{{$client->username}}</td>
                                <td class="border py-2 text-center">{{$client->email}}</td>
                                <td class="border py-2 text-center">{{$client->phone}}</td>
                                <td class="border py-2 text-center">{{$client->country}}</td>
                                <td class="border py-2 text-center">
                                    <div class="text-white bg-amber-400 w-8 h-8 leading-8 rounded-full
                                    mx-auto">
                                       <a href="{{route('searchTaskByClient',$client)}}"> {{count($client->tasks)}}</a>
                                    </div>
                                </td>
                                <td class="border py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{route('client.edit',$client->id)}}" class="bg-emerald-600  px-3 py-1 mr-2">Edit</a>
                                        <form action="{{route('client.destroy',$client->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600  px-3 py-1">Delete</button>
                                        </form>


                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{$clients->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

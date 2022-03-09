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
                                <th class="border py-2">Country</th>
                                <th class="border py-2">Total Task</th>
                                <th class="border py-2">Status</th>
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
                            @forelse ($clients as $client)
                            <tr>
                                <td class="border py-2 w-32 text-center">
                                    <img src="{{getImageUrl($client->thumbnail)}}" width="50" class="mx-auto rounded" alt="">
                                </td>
                                <td class="border py-2 text-left px-3">
                                    <div class="flex flex-col ">
                                        <a class="hover:text-purple-600 font-semibold" href="{{route('client.show',$client)}}">{{
                                            $client->name }}</a>
                                        <span class="text-xs">{{ $client->username }}</span>
                                        <span class="text-xs">{{ $client->email }}</span>
                                    </div>
                                </td>
                                <td class="border py-2 text-center">{{$client->country}}</td>
                                <td class="border py-2 text-center">
                                    <div class="">
                                       <a href="{{route('task.index')}}?client_id={{$client->id}}" class="relative px-3 py-1
                                        bg-teal-600 group inline-block uppercase text-white text-sm">
                                        <span class="absolute group-hover:bg-orange-500 group-hover:text-white
                                        group-hover:border-white transition-all from-neutral-300
                                        bg-white text-black border border-black -right-4 -top-4 rounded-full w-7 h-7 leading-7
                                        text-center text-xs">{{count($client->tasks)}}</span>View</a>
                                    </div>
                                </td>
                                <td class="border py-2 text-center">{{$client->status}}</td>
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
                            @empty
                                <tr>
                                    <td class="text-center border py-2" colspan="6"> No Client Found</td>
                                </tr>
                            @endforelse

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

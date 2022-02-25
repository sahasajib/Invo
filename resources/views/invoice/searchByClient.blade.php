<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $client->name }}
                </h2>
                <p>{{ $client->email }}</p>
                <p>{{ $client->phone }}</p>
            </div>
           <div class="">
            <a href="{{route('task.create')}}" class="border border-green-400 px-3 py-1">{{__('Add New')}}</a>
            <a href="{{route('task.index')}}" class="border border-green-400 px-3 py-1">{{__('Back')}}</a>
           </div>
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
                                <th class="border py-2">#</th>
                                <th class="border py-2">Name</th>
                                <th class="border py-2">Price</th>
                                <th class="border py-2">Status</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client->tasks as $task)
                            <tr>
                                <td class="border py-2 text-center">{{$task->id}}</td>
                                <td class="border py-2 text-left px-2">{{$task->name}}</td>
                                <td class="border py-2 text-center">{{$task->price}}</td>
                                <td class="border py-2 text-center capitalize">{{$task->status}}</td>
                                <td class="border py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{route('task.edit',$task->id)}}" class="bg-emerald-600  px-3 py-1 mr-2">Edit</a>
                                        <a href="{{route('task.show',$task->slug)}}" class="bg-blue-400  px-3 py-1 mr-2">View</a>
                                        <form action="{{route('task.destroy',$task->id)}}" method="post">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

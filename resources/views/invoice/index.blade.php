<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }}
            </h2>
            <a href="{{route('invoice.create')}}" class="border border-green-400 px-3 py-1">{{__('Add New')}}</a>
        </div>

    </x-slot>

    @if (Session('success'))
    <div class="py-2 bg-emerald-300 text-emerald-700 text-center" id="status_message">
        <p>{{Session('success')}}</p>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-md py-10 mb-6 {{request('client_id') || request('status') || request('emailsent')
                 ? '': 'hidden'}}" id="task_filter">
                <h2 class="text-center font-bold mb-6">Filter Invoice</h2>
                <form action="{{ route('invoice.index') }}" method="GET">
                    @csrf

                    <div class="flex space-x-3 items-end justify-center">
                        <div class="">
                            @error('client_id')
                            <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror
                            <label for="client_id" class="formLabel">Select Client</label>
                            <select name="client_id" id="client_id" class="formInput">
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{$client->id == old('client_id') || $client->id == request('client_id')? 'selected' : ''}}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="">
                            @error('status')
                            <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror
                            <label for="status" class="formLabel">Status</label>
                            <select name="status" id="status" class="formInput">
                                <option value="">Status</option>
                                <option value="paid" {{ old('status') == 'paid' || request('status')=='paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ old('status') == 'unpaid' || request('status')=='unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                        </div>
                        <div class="">
                            @error('status')
                            <p class="text-red-700 text-sm">{{ $message }}</p>
                            @enderror
                            <label for="emailsent" class="formLabel">Mail Send</label>
                            <select name="emailsent" id="emailsent" class="formInput">
                                <option value="">Status</option>
                                <option value="yes" {{ old('emailsent') == 'yes' || request('emailsent')=='yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('emailsent') == 'no' || request('emailsent')=='no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="">
                            <button type="submit" class="bg-purple-600 text-white px-3 py-2">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-right">
                        <button type="button" id="tesk_filter_btn" class="px-3 py-1 bg-blue-400 text-white mb-6
                        ">{{request('client_id') || request('status') || request('emailsent')
                         ? 'Close Filter': 'Filter'}}</button>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2 w-36">#</th>
                                <th class="border py-2">Client</th>
                                <th class="border py-2 w-24">Status</th>
                                <th class="border py-2 w-28">Email Sent</th>
                                <th class="border py-2 w-52">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                            <tr>
                                <td class="border py-2 text-center w-36">
                                    <a target="_blank" class="hover:text-purple-600" href="{{asset('storage/invoice/' .
                                    $invoice->download_url)}}">{{$invoice->invoice_id}}</a>
                                </td>
                                <td class="border py-2 text-left px-2">
                                    <a class="hover:text-teal-600" href="{{route('invoice.index')}}?client_id={{$invoice->client->id}}">
                                        {{$invoice->client->name}}</a>
                                </td>
                                <td class="border py-2 text-center capitalize w-24">
                                    {{$invoice->status}}
                                        <form action="{{route('invoice.update',$invoice->id)}}" method="post"
                                              onsubmit="return confirm('did you want continue?');">
                                            @csrf
                                            @method('put')
                                            <button type="submit" class="bg-emerald-600 w-full  px-3 py-1 mr-2 ">{{$invoice->status == 'unpaid' ? 'paid' :'unpaid'}}</button>
                                        </form>
                                </td>
                                <td class="border py-2 text-center capitalize flex flex-col w-28">
                                    {{$invoice->email_sent}}
                                    <a href="{{route('invoice.sendEmail',$invoice)}}" class="bg-green-600 w-full text-sm px-3 py-1 mr-2">Send Mail</a>
                                </td>
                                <td class="border py-2 text-center w-52">
                                    <div class="flex justify-center">
                                        <a target="_blank" href="{{asset('storage/invoice/' .  $invoice->download_url) }}"
                                           class="bg-purple-800 text-white px-3 py-1 mr-2">View</a>
                                        <form action="{{route('invoice.destroy',$invoice->id)}}" method="post"
                                        onsubmit="return confirm('did you really want to delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600  px-3 py-1">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center border py-2" colspan="5"> No Invoice Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{$invoices->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           สวัสดี , {{Auth::user()->name}}

        <b class="float-end">   จำนวนผู้ใช้ระบบ <span>{{count($users)}}</span> คน</b>
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 <x-jet-welcome /> 
           
            </div>
        </div> --}}

        <div class="container">
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">อีเมล</th>
                            <th scope="col">เริ่มใช้งานระบบ</th>
                        </tr>
                    </thead>
                    <tbody >
                        @php($i=1)
                        @foreach ($users as $row)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                                {{-- <td>{{$row->created_at->diffForHumans()}}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

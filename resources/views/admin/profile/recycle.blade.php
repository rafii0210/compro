@extends('layouts_2.app')
@section('content')
    <div class="card">
        <div class="card-header">profiles</div>
        <div class="card-body">
            <a href="{{url('admin/profiles') }}" class="btn btn-secondary btn-sm mb-2">Back</a>
            <div class="table table-reponsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Action</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telpon</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profiles as $index => $item)
                            <tr>
                                {{--  --}}
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ route('profiles.restore', $item->id) }}" class="btn btn-sm btn-success btn-smm mr-2">Restore</a>
                                        {{-- {{ route('profiles.softdelete', $item->id) }} --}}
                                    <form style="display: inline;" action="{{ route('profiles.destroy', $item->id) }}" onsubmit="return confirm('Akan di delete permanen ?');" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->no_telpon }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
@endsection
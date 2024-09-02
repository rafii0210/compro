@extends('layouts_2.app')
@section('content')
    <div class="card">
        <div class="card-header">

    </div>
        <div class="card-body">
            <a href="" class="btn btn-primary btn-sm mb-2">ADD</a>
            <a href="" class="btn btn-warning btn-sm mb-2">BACKUP</a>
            <div class="table table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Action</th>
                            <th>Id Profile</th>
                            <th>Judul</th>
                            <th>Sub Judul</th>
                            <th>Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eksperiences as $index=> $item)
                        <tr>
                            <td>{{  $index + 1}}</td>
                            {{-- {{ route('eksperiences.edit', $item->id)}} --}}
                            <td><a href="" class="btn btn-success btn-sm">Edit</a>
                                {{-- {{ route('eksperiences.softDelete', $item->id) }} --}}
                                <form action="" method="POST" style="display: inline;" onsubmit="return confirm('Akan di delete sementara ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type ="submit" class="btn btn-danger btn-sm">SoftDelete</button>
                                </form>
                                <a href="{{ route('generate-pdf', $item->id) }}" class="btn btn-warning btn-sm">Print</a>
                            </td>
                            <td><input type="radio" name="status" class="status-radio" data-id="{{ $item->id }}" {{ $item->status == 1 ? 'checked' : '' }}></td>
                            <td>{{$item->id_profile}}</td>
                            <td>{{$item->judul}}</td>
                            <td>{{$item->subjudul}}</td>
                            <td>{{$item->descriptiona}}</td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
                 </div>

            </div>
        </div>
        <div class="card-footer">

        </div>
   </div>
@endsection
@section('script-sweetalert')
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const statusRadios = document.querySelectorAll('.status-radio');
        statusRadios.forEach(radio => {
            radio.addEventListener('click', (event) => {
                const itemId = event.target.getAttribute('data-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/admin/eksperience/update-status/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                    Swal.fire(
                        'Berhasil',
                        'Status berhasil diperbarui.',
                        'success'
                    );
                    statusRadios.forEach(r => {
                        if(r.getAttribute('data-id') != itemId){
                            r.checked = false;
                        }
                    });
                }else{
                    Swal.fire(
                        'Gagal',
                        data.error || 'Terjadi kesalahan saat memperbarui status',
                        'error'
                    );
                }
                })
                .catch(error => {
                    Swal.fire(
                        'Gagal',
                        'Terjadi kesalahan saat memperbarui status.',
                        'error'
                    );
                });
            });
        });
    });
</script>
@endsection

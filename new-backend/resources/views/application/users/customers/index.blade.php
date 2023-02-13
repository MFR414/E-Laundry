@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="main-container">
        @if(Session::has('success_message'))
            <div class="card card-success" style='margin-bottom: 20px'>
                <div class="card-header">
                    <div class="header-body">
                        <p class="title" style='color: white; margin: 0;'>Success</p>
                    </div>
                </div>
                <div class="card-body">
                    {{ Session::get('success_message') }}
                </div>
            </div>
        @endif

        @if(Session::has('error_message'))
            <div class="card card-danger" style='margin-bottom: 20px'>
                <div class="card-header">
                    <div class="header-body">
                        <p class="title" style='color: white; margin: 0;'>Error</p>
                    </div>
                </div>
                <div class="card-body">
                    {{ Session::get('error_message') }}
                </div>
            </div>
        @endif
        <br>
        <section>
            <div class="d-flex d-flex d-flex justify-content-between">
                <div class="title">
                    <h3 class="card-title">Daftar Pelanggan</h3>
                </div>
                <div class="tambah-pelanggan">
                    <a class="btn btn-primary btn-md" href="{{ route('application.users.customers.create' )}}">
                        <i class="fa fa-plus">
                        </i>
                        Tambah Pelanggan
                    </a>
                </div>
            </div>
        </section>
        <br>
        <section class="section">
            <div class="card">
                <div class="card-body" style="padding: 5px 10px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="margin-bottom: 0px !important;">
                        <li class="breadcrumb-item"><a href="{{ route('application.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Pelanggan</li>
                    </ol>
                </nav>
                </div>
            </div>
        </section>
        <br>
        <section class="section">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title-body">
                                <h3 class="title">Cari Pelanggan</h3>
                            </div>
                            <form action="{{ route('application.users.customers.index') }}" method="GET" style="margin-bottom: 0">
                                <section>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group" style='margin-bottom: 0'>
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control boxed" name="username" value="{{ $search_terms['username'] }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group" style='margin-bottom: 0'>
                                                <label class="control-label">Nomor Telp</label>
                                                <input type="text" class="form-control boxed" name="phone_number" value="{{ $search_terms['phone_number'] }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group" style='margin-bottom: 0'>
                                                <label class="control-label">Nama</label>
                                                <input type="text" class="form-control boxed" name="name" value="{{ $search_terms['name'] }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <button class="btn btn-primary" style="width: 100%;margin-top: 24px; height: 38px">Cari Pelanggan</button>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered center" style="overflow-x: auto;">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                No
                            </th>
                            <th>
                                Username
                            </th>
                            <th>
                                Nama
                            </th>
                            <th>
                                Alamat
                            </th>
                            <th style="width: 8%" class="text-center">
                                Nomor Telp
                            </th>
                            <th style="width: 20%">
                                Opsi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($customers) <= 0)
                            <tr>
                                <td colspan="6">Tidak Ada Customer</td>
                            </tr>
                        @else
                            @foreach( $customers as $index => $customer )
                            <tr>
                                <td>
                                    {{$customers->firstItem() + $index}}
                                </td>
                                <td>
                                    {{$customer->username}}
                                </td>
                                <td>
                                    {{$customer->name}}
                                </td>
                                <td>
                                    {{$customer->address}}
                                </td>
                                <td>
                                    {{$customer->phone_number}}
                                </td>
                                <td class="project-actions text-right" style="display: flex; gap:5px;">
                                    {{-- <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fa fa-folder">
                                        </i>
                                        View
                                    </a> --}}
                                    <a class="btn btn-primary btn-sm" style="padding-top: 8px;" href="{{ route('application.users.customers.edit', $customer)}}">
                                        <i class="fa fa-pencil">
                                        </i>
                                        Edit
                                    </a>
                                    <form action="{{ route('application.users.customers.destroy', $customer) }}" method="POST" id='deleteForm'>
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" id='deleteBtn' onclick="event.preventDefault();confirmDelete();">
                                            <i class="fa fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card -->

  </section>

  <script>
    function confirmDelete() {
        if(confirm("Apakah anda yakin ingin menghapus data pelanggan ini?")) {
            document.getElementById('deleteForm').submit();
        }
    }
  </script>

@endsection

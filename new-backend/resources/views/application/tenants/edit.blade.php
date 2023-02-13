@extends('layouts.app')

@section('content')
<!-- Main content -->

<section class="content">
    <section class="section">
        <div class="card">
            <div class="card-body" style="padding: 5px 10px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="margin-bottom: 0px !important;">
                    <li class="breadcrumb-item"><a href="{{ route('application.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('application.tenants.index') }}">Daftar cabang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit cabang</li>
                </ol>
            </nav>
            </div>
        </div>
    </section>
    <br>
    <div class="main-container">
        <section>
            <div>
                <div class="title-block">
                    <h1 class="title">Edit cabang</h1>
                    <p class='title-description'>Gunakan form dibawah untuk Merubah data cabang.</p>
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
                                <h3 class="title">Edit cabang</h3>
                            </div>
                            <form action="{{ route('application.tenants.update', $tenant) }}" method="POST" style="margin-bottom: 0">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <section>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Nama</label>
                                                <input type="text" class="form-control underlined" name="name" value="{{ old('name', $tenant->name) }}" placeholder="Masukkan Nama cabang">
                                                @error('name')
                                                <span class="has-error">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Nomor telefon</label>
                                                <input type="text" class="form-control underlined" name="phone_number" value="{{ old('phone_number', $tenant->phone_number) }}" placeholder="Masukkan Nomor Telefon cabang">
                                                @error('phone_number')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="form-group">
                                                <label class="control-label">Alamat</label>
                                                <textarea type="text" class="form-control underlined" name="address" placeholder="Masukkan Alamat cabang">{{ old('address', $tenant->address) }}</textarea>
                                                @error('address')
                                                    <span class="has-error">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mt-3">
                                            <div class="form-group">
                                                <button class="btn btn-primary" style="width: 30%;">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.card -->

  </section>

@endsection

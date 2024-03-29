@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('breadcrumb')
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">Cemara App</a></li>
<li class="breadcrumb-item active">Inventory Index</li>
</ol>
@endsection

@section('content')
<div class="text-center mt-5">
    <h4 class="header-title-lg">{{ strtoupper('Data Inventory Global') }}</h4>
    <div class="sub-str mb-3">
        <p>Cemara Multi Kreatif</p>
    </div>
</div>

<div class="row text-center mb-3">
    <div class="col-12">
        <a href="{{ route('inventory.import.excel') }}" class="btn btn-primary btn-sm">Import dari Excel</a>
        <a href="{{ route('inventory.export.excel') }}" class="btn btn-success btn-sm">Export ke Excel</a>
    </div>
</div>
<div class="table-rep-plugin">
    <div class="table-responsive mb-0" data-pattern="priority-columns">
        <table id="table-cemara-inventory" class="table table-striped">
            <thead>
            <tr>
                <th>Serial Number</th>
                <th data-priority="1">Nama</th>
                <th data-priority="2">Kategori</th>
                <th data-priority="3">Merek</th>
                <th data-priority="4">Supplier</th>
                <th data-priority="5">Harga</th>
                <th class="text-center" data-priority="6">Qty</th>
                <th data-priority="7">Tahun</th>
                <th data-priority="8">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inventories as $inventory)
            <tr>
                <th>
                    <a href="{{ route('inventory.index') }}/{{ $inventory->id }}">
                        <span class="badge badge-primary badge-sn">
                            {{ $inventory->serial_number }}
                        </span>
                    </a>
                </th>
                <th>{{ $inventory->name }}</th>
                <th>{{ $inventory->category->name }}</th>
                <th>{{ $inventory->brand->name }}</th>
                <th>{{ $inventory->supplier->name }}</th>
                <th>@currency($inventory->price)</th>
                <th class="text-center">{{ $inventory->qty }}</th>
                <th>{{ date('Y', strtotime($inventory->year_of_purchase)) }}</th>
                <th>
                    <div class="btn-group" role="group">
                        <a href="{{ route('inventory.index') }}/{{ $inventory->id }}" class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat">
                            <i class="mdi mdi-eye"></i>
                        </a>

                        <a href="{{ route('inventory.index') }}/{{ $inventory->id }}/edit" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="mdi mdi-pencil"></i>
                        </a>

                        <a href="{{ route('inventory.index') }}/{{ $inventory->id }}" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                            <i class="mdi mdi-trash-can"></i>
                        </a>
                    </div>
                </th>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- Redirect ke halaman single item jika hasil pencarian yang ditampilkan cuma 1 data --}}
<script>
    const result = document.querySelectorAll('.table-responsive tbody tr');
    if(result.length == 1) {
        const linkItem = document.querySelector('.table-responsive tbody tr th a');
        linkItem.click();
    }
</script>


<div class="mt-4 text-center">
    {{ $inventories->links() }}
</div>

@endsection
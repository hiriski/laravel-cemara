@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xl-7">
        <div class="card pl-4">
            <div class="card-header bg-transparent p-3">
                <h5 class="header-title-lg mb-0">{{ $inventory->name }}</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Nama Inventory</p>
                            <h5 class="mb-0">{{ $inventory->name }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-layer-group"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Photo Inventory</p>
                            @if (!empty($inventory->image_url))
                            <div class="img-thumbnail rounded">
                                <img class="img-fluid" src="{{ url($inventory->image_url) }}" alt="">
                            </div>
                            @else
                                <h4>Tidak ada foto</h4>
                            @endif
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-layer-group"></i>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Quantity</p>
                            <h5 class="mb-0">{{ $inventory->qty }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-layer-group"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Ketegori</p>
                            <h5 class="mb-0">{{ $inventory->category->name }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-analytics"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Merk</p>
                            <h5 class="mb-0">{{ $inventory->brand->name }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-ruler"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Supplier</p>
                            <h5 class="mb-0">{{ $inventory->supplier->name }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-box"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Harga</p>
                            <h5 class="mb-0">{{ $inventory->price }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-box"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Tahun Beli</p>
                            <h5 class="mb-0">{{ $inventory->year_of_purchase }}</h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-box"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Catatan</p>
                            @if (!empty($inventory->notes))
                                <h6 class="mb-0">{{ $inventory->notes }}</h6>
                            @else
                                <h6 class="mb-0">Nggak ada catatan untuk item ini</h6>
                            @endif
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-layer-group"></i>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="col-xl-5">
        <div class="barcode-inventory">
            <div class="rounded">
                <img class="img-fluid" src="{{ asset('barcode/1.png') }}" alt="">
            </div>
        </div>
    </div>

</div>    

@endsection
@extends('admin/layout/master')

@section('content')
<div class="container-fluid">


    <a href="{{route('sale#info')}}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

    <!-- DataTales Example -->


    <div class="row">
        <div class="card col-5 shadow-sm m-4 col">
            <div class="card-header bg-info text-white fs-4 text-center">
                User Info
              </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-5">Name :</div>
                    <div class="col-7"> {{$orders[0]->user_name !== null ? $orders[0]->user_name : $orders[0]->nickname}} </div>
                </div>
                <div class="row mb-3">
                    <div class="col-5">Phone :</div>
                    <div class="col-7">
                       {{$orders[0]->phone}}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-5">Order Code :</div>
                    <div class="col-7" id="orderCode">{{$payment[0]->orderCode}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5">Order Date :</div>
                    <div class="col-7">{{$payment[0]->created_at->format('d-m-Y')}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5">Total Price :</div>
                    <div class="col-7">{{$payment[0]->totalAmt}}
                        mmk<br>
                        <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card col-5 shadow-sm m-4 col">
            <div class="card-header bg-info text-white fs-4 text-center">
                Payment Info
              </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-5">Contact Phone :</div>
                    <div class="col-7">{{$payment[0]->phone}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5">Addr :</div>
                    <div class="col-7">
                        {{$payment[0]->address}}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-5">Payment Method :</div>
                    <div class="col-7">{{$payment[0]->paymentType}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-5">Purchase Date :</div>
                    <div class="col-7">{{$payment[0]->created_at->format('d-m-Y')}}</div>
                </div>
                <div class="row mb-3">
                    <img style="width: 150px" src="{{asset('paymentImage/'.$payment[0]->payslip_image)}}" class=" img-thumbnail">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <div class="">
                    <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                </div>
            </div>
        </div> --}}
        <div class="card-body">
            <div class="card-header bg-info text-white fs-4 text-center">
                Order Info
              </div>
            <div class="table-responsive">
                <table class="table table-hover shadow-sm " id="productTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="col-2">Image</th>
                            <th>Name</th>
                            <th>Order Count</th>
                            <th>Product Price (each)</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>

                       @foreach ($orders as $item)
                            <tr>
                                <input type="hidden" class="productId" value="{{$item->id}}">
                                <input type="hidden" class="productOrderCount" value="{{$item->count}}">

                                <td>
                                    <img src="{{asset('productPhoto/'.$item->photo)}}" class=" w-50 img-thumbnail">
                                </td>
                                <td class="align-middle">{{$item->name}}</td>
                                <td class="align-middle">{{$item->count}}</td>
                                <td class="align-middle">{{$item->price}}mmk</td>
                                <td class="align-middle">{{ $item->stock * $item->price}} mmk</td>
                            </tr>
                       @endforeach

                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>
@endsection

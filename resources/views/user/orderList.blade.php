@extends('user/layout/master');

@section('content')
<div class="container " style="margin-top: 150px">
    <div class="row">
        <table class="table table-hover shadow-sm ">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Order Code</th>
                    <th>Order Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item => $orders)
                    <tr>
                        <td class="align-middle">{{ $item + 1 }}</td>
                        <td>{{ $orders->created_at->format('d/m/Y') }}</td>
                        <td>{{ $orders->order_code }}</td>
                        <td>
                            @if ( $orders->status == 0 )
                                <div class="text-warning">
                                    <i class="fa-solid fa-hourglass-half"></i></i>
                                    <span>Panding</span>
                                </div>

                            @elseif ( $orders->status === 1 )
                                <div class="text-success">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Accept</span>
                                </div>

                            @else
                                <div class="text-danger">
                                    <i class="fa-solid fa-ban"></i>
                                    <span>Reject</span>
                                </div>

                            @endif
                        </td>
                        <td>
                            <a href="">Order Detail <i class="fa-solid fa-arrow-right"></i></a>
                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>
    </div>
</div>
@endsection

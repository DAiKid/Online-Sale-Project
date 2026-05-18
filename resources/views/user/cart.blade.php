@extends('user/layout/master');

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table" id="productTable">
                <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($carts as $item)

                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('productPhoto/'.$item->photo) }}" class="img-fluid me-5" style="width: 80px; height: 80px;" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">{{ $item->name }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4 price">{{$item->price}} mmk</p>
                            </td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control qty form-control-sm text-center border-0"
                                        value="{{$item->qty}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4 total">{{$item->price * $item->qty}} mmk</p>
                            </td>
                            <td>
                                <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>
                            <td>
                                <input type="hidden" value="{{$item->id}}" name="cartId" class="cartId">
                                <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                <input type="hidden" value="{{$item->stock}}" name="productStock" class="stock">
                                <input type="hidden" class="userId" value="{{Auth::user()->id}}">
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0" id="subtotal">{{$total}}mmk</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Delivery </h5>
                            <div class="">
                                <p class="mb-0"> 5000 mmk </p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4 " id="finalTotal">{{$total+5000}} mmk</p>
                    </div>
                    <button id="btn-checkout"
                        class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                        type="button">Proceed Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-script')

<script>
    $(document).ready(function(){
        $(".btn-plus").click(function(){
            calculationProcess(this);
            // console.log('plus');

        })

        $(".btn-minus").click(function(){
            calculationProcess(this);
            // console.log('minus');
        })

        function calculationProcess(event) {
            let parentNode = $(event).parents('tr');
            let price = parentNode.find('.price').text().replace('mmk','');
            let qty = parentNode.find('.qty').val();
            let total = parentNode.find('.total').text(`${qty*price}mmk`);

            console.log(price);


            let subTotal = 0;
            $('#productTable tbody tr').each(function(index,item){
                subTotal += Number($(item).find('.total').text().replace("mmk",""));
                // console.log(subTotal);
            })

            $('#subtotal').text(`${subTotal} mmk`)
            $('#finalTotal').text(`${subTotal + 5000} mmk`)

        }

        $('.btn-remove').click(function(){
            let cartId = $('.cartId').val();
            console.log(cartId);

            let deleteData = {
                'cartId' : cartId
            }

            $.ajax({
                type : 'get',
                url : '/user/cart/delete',
                data : deleteData,
                dataType : 'json',
                success : function(res){
                    res.status == 'success' ? location.reload()
                    : ""
                },
                error : function(){
                    console.log('error msg...');
                }
            })
        })

        $('#btn-checkout').click(function(){
            let userId = $('.userId').val();
            let orderCode ="Akm " + Math.floor(Math.random()*1000000000);
            let totalCost = $('#finalTotal').text().replace('mmk','');
            let orderList = []

            $("tbody tr").each(function(index, row){
                let productId = $(row).find('.productId').val();
                let count = $(row).find('.qty').val();
                orderList.push({
                    'user_id' : userId,
                    'product_id' : productId,
                    'count' : count,
                    'status' : 0,
                    'order_code' : orderCode,
                    'total_cost' : totalCost,
                })
            })
            // console.log(orderList);
            $.ajax({
                type : 'get',
                url : '/user/cart/temp/Order',
                data : Object.assign({},orderList),
                dataType : 'json',
                success : function(res){
                    // console.log(res);
                    res.status == 'success' ? location.href = "/user/payment/page" : console.log('error')

                }
            })

        })




    })
</script>

@endsection

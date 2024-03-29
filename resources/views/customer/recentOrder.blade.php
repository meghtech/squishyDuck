
@extends('layouts.customer')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<style>
    .card-header i {
        margin-right: 5px;
    }
</style>
@endpush
@section('content')

<!-- Dashboard Content
  ================================================== -->
<div class="dashboard-content-container incoming-request" data-simplebar>
    <div class="dashboard-content-inner" style="background-color: #f2f2f2;" id="app">
    <div class="d-flex flex-row justify-content-between">
        <h2>Incoming Requests</h2>
        <nav id="breadcrumbs" class="dark" style="z-index: 50; position: static;">
            <ul>
                <li><a href="../">Home</a></li>
                <li><a href="../buyer/dashboard">Dashboard</a></li>
                <li>Incoming Requests</li>
            </ul>
        </nav>
    </div>

        <!-- Dashboard Headline -->
        <div class="dashboard-headline">
            <div class="col-8 ml-5 text-right d-inline-block pr-0" style="float:right">
                <select class="col-3 d-inline-block" @change="changeData($event)">
                    <option value="1" :selected="dataOf==1">Bought</option>
                    <option value="2" :selected="dataOf==2">Sold</option>
                </select>
                <a href="{{ route('buyer.recentOrder') }}" class="apply-now-button col-2 ml-4 mb-0 d-inline" style="padding: 12px 20px;"><i class="fa fa-repeat"></i> Refresh</a>
            </div>
        </div>

        <!-- Row -->
        <div class="row" style="width:100%">

            <!-- Dashboard Box -->
            <div class="col-xl-12mm" >
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <div class="input-with-icon">
                    <input id="autocomplete-input" type="text" placeholder="Search a service or customer...">
                    <i style="font-size: 30px;" class="textchat-page-dark icon-material-outline-search"></i>
                </div>
                <div class="dashboard-box margin-top-0">
                        <table v-if="renderComponent" id="example" class="basic-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>List Date</th>
                                    <th>Payment</th>
                                    <th class="text-center">Sale</th>
                                    <th>Price</th>
                                    <th v-if="dataOf == '1'">Seller</th>
                                    <th v-else>Customer</th>
                                    <th>Schedule Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in datas">
                                    <td class="pr-0 pl-0">@{{data.listing.title}}</td>
                                    <td>@{{format_date(data.created_at)}}</td>
                                    <td>
                                        <select @change="updateData(data.id, 'is_accept_seller', index, $event)" :class="{'text-success':data.is_accept_seller==1, 'text-warning': data.is_accept_seller==0}">
                                            <option class="text-warnning" value="0" :selected="data.is_accept_seller==0">Pending</option>
                                            <option  value="1" :selected="data.is_accept_seller==1">Accepted</option>
                                        </select>
                                    </td>
                                    <td class="pr-0">
                                        <select @change="updateData(data.id, 'payment_status', index, $event)" :class="{'text-success':data.payment_status==1, 'text-warning': data.payment_status==0}" :disabled="data.is_accept_seller==0">
                                            <option class="text-warnning" value="0" :selected="data.payment_status==0">Scheduled</option>
                                            <option  value="1" :selected="data.payment_status==1">Received</option>
                                        </select>
                                    </td>
                                    <td>@{{data.amount}}</td>
                                    <td class="pr-0">@{{ data.gig_type===0? data.seller1.name :data.seller2.name }}</td>
                                    <td class="pr-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-calendar mr-2" viewBox="0 0 16 16">
                                            <path
                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                    </svg> @{{ format_date(data.schedule_date) }}</td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <!-- Row / End -->

        <!-- Footer -->
        <div class="dashboard-footer-spacer">
        </div>
        @include('layouts.small-footer')
        <!-- Footer / End -->

    </div>
</div>
<!-- Dashboard Content / End -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            renderComponent: true,
            datas: '',
            dataOf: '1',
            orderConfirmed: 0,
            paymentConfirmed: 0,
        },
        methods: {

            forceRerender() {
                // Remove component from the DOM
                this.renderComponent = false;
                this.$nextTick(() => {
                    // Add the component back in
                    this.renderComponent = true;
                });
            },

            changeData(event){
                this.dataOf = event.target.value;
                var getData = {
                    method: 'post',
                    url: '/buyer/getOrder',
                    data: {
                        type: event.target.value,
                        id: <?php echo json_encode(Auth::user()->id); ?>,
                    }
                };
                axios(getData).then((response) => {
                    this.datas = response.data;
                    this.forceRerender();
                }).catch((e) => {
                    console.log(e)
                })
            },

            format_date(value){
                return moment(String(value)).format('MM/DD/YYYY');
            },

            updateData(id, field, index, event){
                var value =  event.target.value;
                field == "is_accept_seller" ?  this.orderConfirmed = value :  this.paymentConfirmed = value;
                var update = {
                    method: 'post',
                    url: '/buyer/updateOrder',
                    data: {
                        field: field,
                        value: value,
                        id: id,
                        orderConfirmed: this.orderConfirmed,
                        paymentConfirmed: this.paymentConfirmed,
                    }
                };
                axios(update).then((response) => {
                    this.datas[index] = response.data;
                    this.forceRerender();
                })
            }
        },
        mounted() {
            this.datas = <?php echo json_encode($bought); ?>;
        },
    });
</script>
@endsection
@push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@endpush
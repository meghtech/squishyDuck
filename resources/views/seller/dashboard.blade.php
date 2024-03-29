@extends('layouts.seller')

@push('css')

    <style>
        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        .alert-primary {
            color: #f7f7f7;
            background-color: #006171;
            border-color: #b8daff;
        }
    </style>
@endpush

@section('content')

    <?php

    $gigExists = \App\Models\Gig::where('seller_id', auth()->id())->exists();

    ?>

    <!-- Dashboard Content
	================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div   class="dashboard-content-inner" >
            <!-- Dashboard Headline -->
            <div style="margin-left: 7rem" class="dashboard-headline">
                <h3>{{$getUser->name}}</h3>
                <span>We are glad to see you again!</span>

                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li>Dashboard</li>
                    </ul>
                </nav>
            </div>

           
            <!-- Fun Facts Container -->
            <div style="display:flex;justify-content: center" class="fun-facts-container">
                <div class="fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Services</span>
                        <h4>{{$data['services']}}</h4>
                    </div>
                    <div class="fun-fact-icon"><i class="icon-material-outline-gavel"></i></div>
                </div>
                <div class="fun-fact" data-fun-fact-color="#efa80f">
                    <div class="fun-fact-text">
                        <span>Schedule</span>
                        <h4>{{$data['schedule']}}</h4>
                    </div>
                    <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
                </div>

                <!-- Last one has to be hidden below 1600px, sorry :( -->
               
            </div>
            <br>

            {{--  --}}
            <div style="display:flex;justify-content: center" class="fun-facts-container">
               
                <!-- Last one has to be hidden below 1600px, sorry :( -->
                <div  class="fun-fact" data-fun-fact-color="#2a41e6">
                    <div class="fun-fact-text">
                        <span>This Month Earning</span>
                        <h4>{{  $data['thisMonthEarning'] }} </h4>
                    </div>
                    <div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
                </div>

                <div class="fun-fact" data-fun-fact-color="#efa80f">
                    <div class="fun-fact-text">
                        <span>Incoming Requests</span>
                        <h4>{{$data['incommingRq']}}</h4>
                    </div>
                    <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
                </div>
                 
               
            </div>

            <div style="margin-top: 2rem;display:flex;justify-content: center" class="fun-facts-container">
               
                <!-- Last one has to be hidden below 1600px, sorry :( -->
               
                <div  class="fun-fact" data-fun-fact-color="#efa80f">
                    <div class="fun-fact-text">
                        <span>Reviews</span>
                        <h4>{{$data['sellerReview']}}</h4>
                    </div>
                    <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
                </div>
               
            
            </div>

           

            <!-- Footer -->
            <div class="dashboard-footer-spacer"></div>
            <div class="small-footer margin-top-15">
                <div class="small-footer-copyrights">
                    © 2021 <strong>Squishy Duck</strong>. All Rights Reserved.
                </div>
                <ul class="footer-social-links">
                    <li>
                        <a href="#" title="Facebook" data-tippy-placement="top">
                            <i class="icon-brand-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Twitter" data-tippy-placement="top">
                            <i class="icon-brand-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Google Plus" data-tippy-placement="top">
                            <i class="icon-brand-google-plus-g"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="LinkedIn" data-tippy-placement="top">
                            <i class="icon-brand-linkedin-in"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Footer / End -->

        </div>
    </div>
    <!-- Dashboard Content / End -->





@endsection

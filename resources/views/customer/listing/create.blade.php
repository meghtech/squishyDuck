@extends('layouts.customer')

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
        .toaster{
            position: absolute;
            width: 24rem;
            height: 5rem;
            background-color: rgba(68, 197, 68, 0.397);
            float: left;
            margin-top: 2rem;
            z-index: 10000;
            visibility: hidden;
        }
        .toasterError{
            position: absolute;
            width: 24rem;
            height: 5rem;
            background-color: rgba(245, 28, 28, 0.397);
            float: left;
            margin-top: 2rem;
            z-index: 10000;
            visibility: hidden;
        }
        .t_container{
            width: 100rem;
            z-index: 20000;
            background-color: red
        }
    </style>
@endpush

@section('content')
    <!-- Dashboard Content
	================================================== -->
    <div id="app" class="dashboard-content-container create-service pl-5 pr-5 ml-6 mr-5">

        <div class="t_container" >
            <div id="aa" class="toaster">
    
                <div class="" style="margin-left: 1rem">
                    <h1 style="color: white">Success!</h1>
                <p>Your Service is Submitted</p>
                </div>
            </div>
    
            <div id="errorToast" class="toasterError">
    
                <div class="" style="margin-left: 1rem">
                    <h1 style="color: white">Error!</h1>
                <p>Please Insert All Data</p>
                </div>
            </div>
        </div>
        <div class="dashboard-content-inner">
            <section v-if="section == 'first'">
                <div class="row">
                    <div class="col-sm-12 col-md-10">
                        <input type="text" placeholder="Listing Title..." v-model="title">
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <span class="input-symbol-dollar">
                            <input class="price" type="text" placeholder="0.00" v-model="price">
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <textarea name="about" cols="30" rows="10" class="with-border" placeholder="Description..." v-model="description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input type="text" data-role="tagsinput" placeholder="#EnterTagsHere" id="tags"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="text" placeholder="Street Address" v-model="listingAddress"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <input type="text" placeholder="sqft" v-model="size"/>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <select name="for_type" v-model="for_type">
                            <option disabled value="">For</option>
                            <option value="rent">Rent</option>
                            <option value="sell">Sell</option>
                            <option value="renovated">Renovation</option>
                        </select>
                    </div>
                </div>
                <div class="row pt-5 mt-5 mb-5">
                    <div class="col-md-12 col-sm-12 text-center">
                        <button class="btn btn-md-cyan pl-5 pr-5" @click="changeSection">Next</button>
                    </div>
                </div>
            </section>
            <section v-else-if="section == 'second'">
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12">
                        <input type="text" placeholder="Contact Email" v-model="contactEmail">
                    </div>
                    <div class="col-md-12 col-sm-12 row m-0 p-0">
                        <div class="col-md-6 col-sm-12">
                        <input type="text" placeholder="Contact Name" v-model="contactName">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <input type="text" placeholder="Phone Number" v-model="phoneNumber">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 row m-0 p-0 mb-4">
                        <div class="col-md-9 col-sm-12"></div>
                        <div class="col-md-3 col-sm-12 d-flex call-text">
                            <input type="checkbox" class="mr-2 ml-4" value="1" v-model="callMe"> <span style="font-size:14px;">Call Me</span>
                            <input type="checkbox" class="mr-2 ml-4" value="1" v-model="textMe"> <span style="font-size:14px;">Text Me</span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <input type="text" placeholder="Street Address" v-model="streetAddress">
                    </div>
                    <div class="col-md-12 col-sm-12 row p-0 m-0">
                        <div class="col-md-8 col-sm-12">
                            <input type="text" placeholder="City" v-model="city">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <select name="state" v-model="state">
                                <option value="" disabled>State</option>
                                <option value="CO">CO</option>
                                <!-- <option value="CA">CA</option>
                                <option value="LA">LA</option>
                                <option value="FL">FL</option> -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" placeholder="Zip" v-model="zip">
                        </div>
                    </div>
                    <div class="row p-0 m-0">
                        <div class="col-md-12 col-sm-12">
                            <textarea name="deliveryDetails" cols="110" rows="2" class="with-border" placeholder="Pickup or delivery details..." v-model="deliveryDetails"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row pt-5 mt-5 mb-5">
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn outline-md-cyan pl-5 pr-5" @click="goBack">Cancel</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button class="btn btn-md-cyan pl-5 pr-5" @click="changeSection">Next</button>
                    </div>
                </div>
            </section>
            <section v-else-if="section == 'third'">
                <h3 class="mt-5 text-center">Upload 1-10 Images</h3>
                <div class="row p-0 m-0">
                    <div class="col-md-2 col-sm-12">
                        <div class="ad-image text-center" id="viewImage_0">
                            <img src="{{ asset('content/images/duck.svg') }}" />
                            <input id="files" type='file' style="display:none" @change="showImage"
                                accept="image/png, image/gif, image/jpeg, image/jpg" multiple />
                                
                        </div>
                        <img id="displayImage_0" class="ad-image d-none" />
                        <label for="files" class="btn btn-success uploadImage mt-4 text-center"><i
                                class="fa fa-long-arrow-up uploadIcon"></i>Upload Image</label>
                    </div>
                    <div id="preview"></div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_1"></div>
                        <img id="displayImage_1" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_2"></div>
                        <img id="displayImage_2" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_3"></div>
                        <img id="displayImage_3" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_4"></div>
                        <img id="displayImage_4" class="ad-image d-none" />
                    </div>

                </div>
                <div class="row p-0 m-0 ml-5" style="margin-top: -6% !important; margin-left:10rem !important;">
                    <div class="col-md-2 col-sm-12"></div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_5"></div>
                        <img id="displayImage_5" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_6"></div>
                        <img id="displayImage_6" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_7"></div>
                        <img id="displayImage_7" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_8"></div>
                        <img id="displayImage_8" class="ad-image d-none" />
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_9"></div>
                        <img id="displayImage_9" class="ad-image d-none" />
                    </div>
                </div>

                <div class="row pt-5 mt-5 mb-5">
                    <div class="col-md-6 col-sm-12 text-right">
                        <button type="button" class="btn outline-md-cyan pl-5 pr-5" @click="goBack">Cancel</button>
                    </div>
                    <div class="col-md-6 col-sm-12 text-left">
                        <button class="btn btn-md-cyan pl-5 pr-5" style="color:white" @click="changeSection" >Next</button>
                    </div>
                </div>
            </section>
            <section v-else-if="section == 'forth'">
                <h3 class="mt-4 text-center">Submit This Post?</h3>
                <div class="row mt-5 p-5 bg-white productView">
                    <div class="col-md-2 col-sm-12 p-0 mr-4">
                        <img @load="addSrc" id="displayImage_11" class="ad-image"/>
                    </div>
                    <div class="col-4 p-0">
                        <h4 class='pt-1 pb-1'>@{{title}}</h4>
                        <h1 class="text-success mb-3">$@{{price}}/mo</h1>
                        <div>
                            <img class="bg-md-cyan border rounded-circle" alt="user" height="30px" width="30px">
                            <span class="text-md-cyan" style="font-size:14px">{{Auth::user()->name}}</span>
                        </div>
                    </div>
                    <div class="col-5 p-0 ml-5 text-right">
                        <p class='pt-1 pb-1 m-0' style="font-size: 14px;">3 bed, 2 bath, @{{size}} sqft</p>
                        <h4 class="mb-3">@{{listingAddress}}</h4>
                        <span v-for="tag in tags" class="ml-2 p-1 showTags">@{{tag}}</span>
                    </div>
                    <div class="col-12 mt-3 p-0">
                        <p style="font-size: 12px;" class=" ml-2">Description</p>
                        <p style="font-size: 14px;" class="mt-3">@{{description}}</p>
                    </div>
                </div>
                <div class="row pt-5 mt-5 mb-5">
                    <div class="col-md-6 col-sm-12 text-right">
                        <button type="button" class="btn outline-md-cyan pl-5 pr-5" @click="goBack">Cancel</button>
                    </div>
                    <div class="col-md-6 col-sm-12 text-left">
                        <button class="btn btn-md-cyan pl-5 pr-5" style="color:white" @click="postData" onclick="showProgress()">Submit</button>
                    </div>
                </div>
            </section>
            <div class="progress" style="height: 30px; display:none" id="progressBar">
                <div class="progress-bar progress-bar-striped progress-bar-animated text-left pl-3" style="width:100%">Submiting</div>
            </div>
        </div>
            <!-- Fun Facts Container -->
    </div>
    <!-- Dashboard Content / End -->
    @include('layouts.large-footer')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function showProgress(){
    document.getElementById("progressBar").style.display="block";
}
</script>

<script>
    new Vue({
        el: '#app',
        data: {
            renderComponent: true,
            section: 'first',
            title: '',
            price: '',
            description: '',
            tags: [],
            listingAddress: '',
            size: '',
            for_type: '',
            contactEmail: '',
            contactName: '',
            phoneNumber: '',
            callMe: 0,
            textMe: 0,
            streetAddress: '',
            city: '',
            state: '',
            zip: '',
            type: 'listing',
            deliveryDetails: '',
            images: [],
            thumbnail: '',
        },
        methods: {

            

            
            hideToast(id){
                setTimeout(() => {   (id).visibility = "hidden";
                    (id).style.visibility = "hidden";
            }, 3000);
   

            },


            changeSection(){
                window.scrollTo(0,0);
                if (this.section == 'first') {
                    this.tags = document.getElementById('tags').value.split(',');
                    this.section = 'second';
                } else if (this.section == 'second') {
                    this.section = 'third';
                } else if (this.section == 'third') {
                    this.section = 'forth';
                }
            },

            goBack(){
                window.scrollTo(0,0);
                if (this.section == 'second') {
                    this.section = 'first';
                } else if (this.section == 'third') {
                    this.section = 'second';
                } else if (this.section == 'forth') {
                    this.section = 'third';
                }
            },

            uploadImage(){
                document.getElementById('files').click();
            },

            async showImage() {
                imgLen = this.images.length;
                var src = document.getElementById("files").files;
                for (let index = 0; index < src.length; index++) {
                    var fr = new FileReader();
                    await fr.readAsDataURL(src[index]);
                    let imgStr = ''
                    fr.onload = await (function (index, event) {
                        var displayImage = document.getElementById('displayImage_' + (index+imgLen));
                        displayImage.src = event.target.result;
                        // console.log(displayImage.src);
                        imgStr = event.target.result;
                        displayImage.classList.remove('d-none');
                        if (index == '0') {
                            this.thumbnail = event.target.result;
                        }
                    }).bind(event, index);

                    await setTimeout(() => {
                        this.images[index+imgLen] = imgStr;
                        // console.log("img Len: "+this.images.length)
                    }, 200);
                    
                    document.getElementById('viewImage_' + (index+imgLen)).classList.add('d-none');
                    if(imgLen+index ===9){
                        break;
                    }
                }
                // console.log(this.images);
            },

            addSrc() {
                document.getElementById('displayImage_11').src = this.thumbnail;
            },

            postData(){
                let formData = new FormData();
                formData.append('title', this.title);
                formData.append('price', this.price);
                formData.append('description', this.description);
                formData.append('tags', JSON.stringify(this.tags));
                formData.append('listingAddress', this.listingAddress);
                formData.append('size', this.size);
                formData.append('for_type', this.for_type);
                formData.append('contactEmail', this.contactEmail);
                formData.append('contactName', this.contactName);
                formData.append('phoneNumber', this.phoneNumber);
                formData.append('callMe', this.callMe);
                formData.append('textMe', this.textMe);
                formData.append('streetAddress', this.streetAddress);
                formData.append('city', this.city);
                formData.append('state', this.state);
                formData.append('zip', this.zip);
                formData.append('type', this.type);
                formData.append('deliveryDetails', this.deliveryDetails);

                if(this.images.length > 0){
                    this.images.forEach((value, key) => {
                        formData.append('image_'+key, value);
                    });
                    formData.append('photoLength', this.images.length);
                }
                // if(images.length > 0){
                //     images.forEach((value, key) => {
                //         formData.append('image_'+key, value);
                //     });
                //     formData.append('photoLength', images.length);
                // }

                axios.post('/buyer/post-listing', formData, {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    console.log(response.data);
                    window.location.replace('/buyer/market');
                }).catch(error => {

                    var errorId= document.getElementById("errorToast");
                    errorId.style.visibility = "visible";
                    this.hideToast(errorId);
                    document.getElementById("progressBar").style.display="none";

                    console.log(error.response.data.message)
                });
            }
        },
        mounted() {
            console.log("Mounted");
        },
    });
</script>
@endsection

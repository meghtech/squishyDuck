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
    <!-- Dashboard Content
	================================================== -->
    <div id="app" class="dashboard-content-container create-service pl-5 pr-5 ml-6 mr-5">
        <div class="dashboard-content-inner">
            <section v-if="section == 'first'">
                <div class="row">
                    <div class="col-sm-12 col-md-10">
                        <input type="text" placeholder="Posting Title..." v-model="title">
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
                    <div class="col-md-6 col-sm-12">
                        <input type="text" placeholder="Make/Manufacturer (if applicable)" v-model="manufacturer"/>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <input type="text" placeholder="Model Name/Number (if applicable)" v-model="model"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <input type="text" placeholder="Length x Width x Height" v-model="dimension"/>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <select name="condition" v-model="condition">
                            <option disabled value="">Select Condition</option>
                            <option value="New">New</option>
                            <option value="Used">Used</option>
                            <option value="Restored">Restored</option>
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
                                <option value="CA">CA</option>
                                <option value="LA">LA</option>
                                <option value="FL">FL</option>
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
                            <img src="{{ asset('content/images/duck.svg') }}"/>
                            <input id="files" type='file' style="display:none" @change="showImage" accept="image/png, image/gif, image/jpeg, image/jpg" multiple/>
                        </div>
                        <img id="displayImage_0" class="ad-image d-none"/>
                        <button class="btn btn-success uploadImage mt-4 text-center" @click="uploadImage"><i class="fa fa-long-arrow-up uploadIcon"></i>Upload Image</button>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_1"></div>
                        <img id="displayImage_1" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_2"></div>
                        <img id="displayImage_2" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_3"></div>
                        <img id="displayImage_3" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_4"></div>
                        <img id="displayImage_4" class="ad-image d-none"/>
                    </div>

                </div>
                <div class="row p-0 m-0 ml-5" style="margin-top: -6% !important;">
                    <div class="col-md-2 col-sm-12"></div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_5"></div>
                        <img id="displayImage_5" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_6"></div>
                        <img id="displayImage_6" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_7"></div>
                        <img id="displayImage_7" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_8"></div>
                        <img id="displayImage_8" class="ad-image d-none"/>
                    </div>
                    <div class="col-md-1 col-sm-12 mr-5 viewImages">
                        <div class="ad-image text-center" id="viewImage_9"></div>
                        <img id="displayImage_9" class="ad-image d-none"/>
                    </div>
                </div>
                <div class="row pt-5 mt-5 mb-5">
                    <div class="col-md-6 col-sm-12 text-right">
                        <button type="button" class="btn outline-md-cyan pl-5 pr-5" @click="goBack">Cancel</button>
                    </div>
                    <div class="col-md-6 col-sm-12 text-left">
                        <button class="btn btn-md-cyan pl-5 pr-5" @click="changeSection">Next</button>
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
                        <h1 class="mb-3"><span class="text-success">$@{{price}}</span></h1>
                        <div>
                            <img class="bg-md-cyan border rounded-circle" alt="user" height="30px" width="30px">
                            <span class="text-md-cyan" style="font-size:14px">{{Auth::user()->name}}</span>
                        </div>
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
                        <button class="btn btn-md-cyan pl-5 pr-5" @click="postData">Next</button>
                    </div>
                </div>
            </section>
        </div>
            <!-- Fun Facts Container -->
    </div>
    <!-- Dashboard Content / End -->
    @include('layouts.large-footer')
<script src="{{ asset('js/app.js') }}"></script>
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
            manufacturer: '',
            model: '',
            dimension: '',
            condition: '',
            contactEmail: '',
            contactName: '',
            phoneNumber: '',
            callMe: 0,
            textMe: 0,
            streetAddress: '',
            city: '',
            state: '',
            zip: '',
            type: 'market',
            deliveryDetails: '',
            images: [],
            thumbnail: '',
        },
        methods: {
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

            showImage() {
                this.images = [];
                var src = document.getElementById("files").files;
                src.length > 10 ? src.length = 10 : '';
                if(src.length < 10) {
                    for (let i=src.length; i < 10; i++) {
                        document.getElementById('displayImage_'+i).removeAttribute("src");
                    }
                }
                for (let index = 0; index < src.length; index++) {
                    var fr=new FileReader();
                    fr.readAsDataURL(src[index]);
                    fr.onload = (function(index, event) {
                        var displayImage = document.getElementById('displayImage_'+index);
                        displayImage.src = event.target.result;
                        displayImage.classList.remove('d-none');
                        if(index=='0') {
                            this.thumbnail = event.target.result;
                        }
                    }).bind(event, index);
                    this.images[index] = src[index];
                    document.getElementById('viewImage_'+index).classList.add('d-none');
                }
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
                formData.append('manufacturer', this.manufacturer);
                formData.append('model', this.model);
                formData.append('dimension', this.dimension);
                formData.append('condition', this.condition);
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
                        formData.append('image-'+key, value);
                    });
                    formData.append('photoLength', this.images.length);
                }

                axios.post('/seller/post-inventory', formData, {
                    headers: {
                    'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    console.log(response.data);
                });
            }
        },
        mounted() {
            console.log("Mounted");
        },
    });
</script>
@endsection

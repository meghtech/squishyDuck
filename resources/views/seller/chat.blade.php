@extends('layouts.seller')
@section('content')
<!-- Chat Content
	================================================== -->
<div class="container-fluid full-page-content-inner pt-0 pl-0 pr-0 chat-page" style="max-height:100%; max-width:100%;"
    id="sellerChatPage">
    <section class="col-sm-12 col-md-3 col-lg-3 pl-0 pr-0 pb-0 chatSection sections" style="position:relative;">
        <div class="col-12 col-md-3 col-lg-3 mt-4 mb-4 search-message" style="position:fixed;">
            <div class="input-with-icon">
                <input id="autocomplete-input" type="text" placeholder="Search Messages ...">
                <i style="font-size: 25px;" class="textchat-page-dark icon-material-outline-search"></i>
            </div>
        </div>
        <div class="chat-list">
            <div v-for="(list, listIndex) in chatList" class="col-sm-12 chat-to-list row m-0 p-3 pl-4"
                :class="{'selected-chat': checkSelection(list)}" @click="changeChatTo(list)">
                <div class="user-avatar d-inline m-0" :class="{ 'status-online': checkIfOnline(list, 'chatList') }"><img
                        src="{{ asset('storage/upload/profile') }}" alt=""></div>
                <div class="col-8 col-sm-7 pr-0">
                    <h4 class="text-white"><b>@{{list && getChatUserInfo(list, 'name')}}</b></h4>
                    <h5 class="text-white">@{{list.msg}}</h5>
                </div>
                <div class="col-2 col-sm-2 ml-3">
                    <h5 class="text-gray">@{{list.msg ? convertDate(list.created_at) : ''}}</h5>
                </div>
            </div>

        </div>
    </section>
    <section class="col-sm-12 col-md-9 col-lg-9 pr-0 pl-0 bg-white sections" style="float:right; position:relative;">
        <div class="col-12 m-0 mt-3 mb-0 chat-top-section row pr-0">
            <div class="col-10 mb-3">
                <span class="d-inline-block bookmark-icon"></span>
                <h3 class="d-inline-block ml-3"><b>@{{chatTo && getChatUserInfo(chatTo, 'name')}}</b></h3>
            </div>
            <div class="col-2 text-right mt-3 pr-5">
                <i class="fa fa-ellipsis-v" style="font-size:24px; color:#aaa;"></i>
            </div>
        </div>
        <div class="container-fluid messages" id="viewMessages">
            <div class="col-sm-12 row m-0 p-3 pl-4" v-for="(message, messageIndex) in messages">
                <div class="user-avatar d-inline m-0 mt-2" :class="{ 'status-online': checkIfOnline(message, 'chat')}">
                    <img src="{{ asset('storage/upload/profile') }}" alt=""></div>
                <div class="col-10 col-sm-10 pr-0">
                    <h5 class="text-black d-inline mr-4"><b>@{{getMsgSenderInfo(message, 'name')}}</b></h5><span
                        class="text-gray" style="font-size:.8rem">@{{formatTime(message.created_at)}}</span>
                    <h6 class="text-black" v-if="message.message_type==1">@{{message.msg}}</h6>
                    <img class="d-block" :src="getImage(message.file)" height="150px" width="auto" v-else>
                </div>
            </div>
        </div>
        <div class="row m-0 p-0"
            style="width:100%; margin-bottom:0;background-color:#f2f2f2; position:relative;">
            <div class="auto-respond col-1 col-sm-1 mb-0 p-0 text-center" @click="toggleQuickRespond()">
                <img class="mt-3" height="25px" src="{{ asset('content/images/autoResponder.svg') }}"
                    alt="Auto respond">
            </div>
            <div class="respond_container">
                <div  v-if="quickRespond" style="z-index:2000"
                 class="floting_menu">
                    <p class="f_op_name" v-for="(respond, respond_index) in responds"
                        @click="sendResponse(respond_index)">@{{respond}}</p>
                    <p @click="toggleQuickRespond()" class="f_op_btn">Cancel</p>
                </div>
            </div>
            <div class="uploadButton col-1 col-sm-1 m-0 p-0">
                <input name="image" class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload"
                    @change="selectFile">
                <label class="uploadButton-button ripple-effect mb-0 text-center" for="upload">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" fill="currentColor"
                        class="bi bi-paperclip" viewBox="0 0 16 16">
                        <path
                            d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z" />
                    </svg>
                </label>
            </div>
            <div class="uploadButton col-1 col-sm-1 m-0 p-0" v-if="messageType==2">
                <label class="uploadButton-button ripple-effect mb-0 text-center" @click="removeFile()">X</label>
            </div>
            <!-- <span class="uploadButton-file-name mb-0 col-9 col-sm-9 pl-4"></span> -->
            <input type="text" class="message-box mb-0 col-10 col-sm-10 pl-4" id="message-box"
                placeholder="Start typing ..." v-model="message" @keyup.enter="sendMessage()"
                :disabled="messageType==2">
            <div class="send-button col-1 col-sm-1 mb-0 p-0 text-center" @click="sendMessage()">
                <img class="mt-3" height="25px" src="{{ asset('content/images/send.svg') }}" alt="Send">
            </div>
        </div>
        <div class="pl-4 pr-4" style="width:100%; margin-bottom:0;background-color:#f2f2f2;">
            @include('layouts.small-footer')
        </div>
    </section>
</div>
<!-- Chat Content / End -->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    new Vue({
        el: '#sellerChatPage',
        data: {
            users: [],
            messages: [],
            chatList: [],
            message: '',
            chatTo: '',
            chatToId: '',
            authUser: '',
            file: '',
            receiver_type: '',
            messageType: 1,
            activeUser: false,
            typingTimer: false,
            quickRespond: false,
            responds: ["I'm driving, and I'm 20 minutes from you.", "I'm driving, and I'm 10 minutes from you.", "I'm driving, and I'm 5 minutes from you."],
        },
        methods: {
            orderChatList() {
                this.chatList.sort((b, a) => {
                    return new Date(a.created_at) - new Date(b.created_at);
                });
            },
            scrollToBottom() {
                var container = document.getElementById("viewMessages");
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight
                }, 10);
            },
            getChatUserInfo(list, param) {
                if (list.user_id == this.authUser.id && list.sender_type === "seller") {
                    if (list.receiver_type === "seller") {
                        return list.receiver1[param];
                    } else if (list.receiver_type === "customer") {
                        return list.receiver2[param];
                    }
                } 
                else {
                        return list.user2[param];
                }
            },
            getMsgSenderInfo(list, param) {
                if (list.sender_type === "seller") {
                    return list.user1[param]
                } else if (list.sender_type === "customer") {
                    return list.user2[param];
                }
            },
            checkIfOnline(list, param) {
                if (param == 'chatList') {
                    var id = this.getChatUserInfo(list, 'id');
                } else if (param == 'chat') {
                    var id = this.getMsgSenderInfo(list, 'id');
                }
                var online = false;
                if (id == this.authUser.id) {
                    online = true;
                } else {
                    this.users.map(user => {
                        if (user.id == id) {
                            online = true;
                        }
                    })
                }
                return online;
            },
            isAuthUser(list) {
                return list.user_id == this.authUser.id
            },
            checkSelection(user) {
                if (user.receiver_id == this.authUser.id) {
                    if ((this.chatTo.user_id == user.user_id || this.chatTo.receiver_id == user.user_id)) {
                        return true;
                    }
                } else {
                    if ((this.chatTo.user_id == user.receiver_id || this.chatTo.receiver_id == user.receiver_id)) {
                        return true;
                    }
                }
            },
            changeChatTo(user) {
                this.chatTo = user;
                if (user.receiver_id == this.authUser.id && user.sender_type === 'customer') {
                    this.chatToId = user.user_id;
                    this.receiver_type = user.sender_type
                    this.fetchMessage(this.authUser.id, this.chatToId);
                } else {
                    this.chatToId = user.receiver_id;
                    this.receiver_type = user.receiver_type
                    this.fetchMessage(this.authUser.id, this.chatToId);
                }
            },
            convertDate(date) {
                return moment(date).fromNow();
            },
            formatTime(date) {
                return moment(date).format('hh:mm A');
            },
            selectFile(e) {
                this.file = e.target.files[0];
                this.messageType = 2;
                this.message = this.file.name;
                document.getElementById("message-box").classList.add('message-box-flex');
            },
            removeFile() {
                this.file = '';
                this.messageType = 1;
                this.message = '';
                document.getElementById("message-box").classList.remove('message-box-flex');
            },
            fetchMessage(userId, chatTo) {
                var options = {
                    method: 'post',
                    url: '/fetchSellerMessage',
                    data: {
                        a: userId,
                        sender_type: "seller",
                        b: chatTo,
                        receiver_type: this.receiver_type,
                    }
                };
                axios(options).then((response) => {
                    this.messages = response.data;
                    this.scrollToBottom();
          
              });
            },
            getImage(file) {
                asset = @json(asset('/content/images/message\/'));
                return asset + file
            },
            sendMessage() {
                if (this.message.length > 0) {
                    if (this.messageType == 1) {
                        var options = {
                            method: 'post',
                            url: '/sendSellerMessage',
                            data: {
                                msg: this.message,
                                receiver_id: this.chatToId,
                                receiver_type: this.receiver_type,
                                user_id: this.authUser.id,
                                sender_type: 'seller',
                                message_type: this.messageType,
                            }
                        };
                        axios(options).then((response) => {
                            this.chatList.map((list, index) => {
                                if((list.user_id === this.chatToId && list.sender_type === this.receiver_type) || (list.receiver_id === this.chatToId && list.receiver_type === this.receiver_type)) {
                                    this.chatList[index].msg = this.message;
                                }
                            })
                            this.messages.push(response.data);
                            this.message = '';
                            this.scrollToBottom();
                        })
                    } else if (this.messageType == 2) {
                        var formData = new FormData();
                        formData.append("file", this.file);
                        formData.append("user_id", this.authUser.id);
                        formData.append("sender_type", 'seller');
                        formData.append("receiver_id", this.chatToId);
                        formData.append("receiver_type", this.receiver_type);
                        formData.append("message_type", this.messageType);
                        axios.post('/sendSellerMessage', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((response) => {
                            this.messages.push(response.data);
                            this.removeFile();
                            this.scrollToBottom();
                        })
                    }
                }
            },
            toggleQuickRespond() {
                this.quickRespond ? this.quickRespond = false : this.quickRespond = true;
            },
            sendResponse(index) {
                this.message = this.responds[index];
                this.file = '';
                this.messageType = 1;
                this.toggleQuickRespond();
                this.sendMessage();
            },
        },
        mounted() {
            this.authUser = @json($authUser);
            this.chatList = @json($chatList);
            this.receiver_type = @json($receiver_type);
            @json($messages) ? this.messages = @json($messages) : '';
            this.chatToId = @json($chatTo -> id);
            this.scrollToBottom();
            this.chatList.map(user => {
                if (user.user_id == this.authUser.id) {
                    if (user.receiver_id == this.chatToId) {
                        this.chatTo = user;
                    }
                } else {
                    if (user.user_id == this.chatToId) {
                        this.chatTo = user;
                    }
                }
            });
            this.orderChatList();
            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('.NewMessage', (event) => {
                    if(event.message.receiver_id === this.authUser.id && event.message.receiver_type === 'seller') {
                        let userInList = false;
                        let userInListIndex = null;
                        this.chatList.map((list, index) => {
                            if((list.user_id === event.message.user_id && list.sender_type === event.message.sender_type) || (list.receiver_id === event.message.user_id && list.receiver_type === event.message.sender_type)) {
                                userInList = true
                                userInListIndex = index;
                            }
                        })
                        if(userInList) {
                            this.chatList[userInListIndex].msg = event.message.msg
                        } else {
                            this.chatList.unshift(event.message)
                        }
                        if(this.chatTo.receiver_id === event.message.user_id) {
                            this.messages.push(event.message);
                            this.scrollToBottom();
                        }
                    }
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;
                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 1000);
                })
            this.scrollToBottom();
        },
    })
</script>
@endsection
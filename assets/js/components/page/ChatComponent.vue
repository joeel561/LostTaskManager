<template>
    <div class='row no-gutters chat-user--wrapper align-items-start'>
        <div class='chat-sidebar--wrapper d-block d-md-none'>
            <b-button v-b-toggle.sidebar-chat-toggle class='chat-sidebar-toggle--btn'>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>
            </b-button>
            <b-sidebar id="sidebar-chat-toggle" :backdrop-variant="variant" backdrop text-variant="light" bg-variant="dark">
                <template #header="{ hide }">
                    <div class="d-flex align-items-center justify-content-between col-12">
                        <headline-component title="Chat" classes='h1'></headline-component>
                        <div class='chat-user--icon'>
                            <button class="btn" v-on:click="openUserDropdown()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 11h6m-3 -3v6" />
                                </svg>
                            </button>
                            <div class="chat-user--dropdown mobile-chat--dropdown" v-bind:class="{active: isActive }">
                                <input class="form-control" v-model="keyword" placeholder="Search user"/>
                                <div v-for="user in filteredUsers" :key="user.id"  v-on:click="addUser(user.id)">{{user.username}}</div>
                                <div class="dropdown--overlay" v-on:click="closeUserDropdown()"></div>
                            </div>
                        </div>
                        <b-button @click="hide" class="close">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </b-button>
                    </div>
                </template>
                <div class='chat-user--list'>
                    <div class='chat-user--item' v-on:click="openChat(participant.id)"  
                    v-bind:class="{active: participant.id  === ChatisActive}" 
                    v-for="participant in computedParticipants"
                    :key="participant.id">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>{{ participant.username }}</span>
                    </div>
                </div>
            </b-sidebar>
        </div>
        <div class='col-md-4 d-none d-md-block'>
            <div class='chat-user--panel'>
                <div class='chat-user--headline d-flex justify-content-between'>
                    <headline-component title="Chat" classes='h1'></headline-component>
                    <div class='delete--icon'>
                        <button class="btn" v-on:click='openDeleteModal()'>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-trash"
                                width="44"
                                height="44"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#2c3e50"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="4" y1="7" x2="20" y2="7" />
                                <line x1="10" y1="11" x2="10" y2="17" />
                                <line x1="14" y1="11" x2="14" y2="17" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </button>
                        <b-modal ref="deleteModal" hide-footer id="deleteModal"  @hidden="resetDeleteModal">
                            <div class="d-block text-center">
                                <h3>Are you sure you want to delete the Chat?</h3>
                            </div>
                            <b-alert v-model="deletedChat" variant="success" dismissible>
                                Chat is deleted successfully!
                            </b-alert>
                            <b-button class="mt-3" block @click="closeDeleteModal()">No, go back</b-button>
                            <b-button class="mt-2" block @click="deleteChat()">Yes, delete it</b-button>
                        </b-modal>
                    </div>
                    <div class='chat-user--icon'>
                        <button class="btn" v-on:click="openUserDropdown()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 11h6m-3 -3v6" />
                            </svg>
                        </button>
                        <div class="chat-user--dropdown" v-bind:class="{active: isActive }">
                            <input class="form-control" v-model="keyword" placeholder="Search user"/>
                            <span v-for="user in filteredUsers" :key="user.id"  v-on:click="addUser(user.id)">{{user.username}}</span>
                        </div>
                        <div class="dropdown--overlay" v-bind:class="{active: isActive }" v-on:click="closeUserDropdown()"></div>
                    </div>
                </div>
                <div class='chat-user--list'>
                    <div class='chat-user--item' v-on:click="openChat(participant.id)"  
                        v-bind:class="{active: participant.id  === ChatisActive}" 
                        v-for="participant in computedParticipants"
                        :key="participant.id">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>{{ participant.username }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-8 pl-md-3 chat-message--box'>
            <div id="chat-wrapper" class='chat-wrapper'>
                <div class='chat-wrapper--spacer'></div>
                <div class='text-white chat-text-box' v-show="isShow" v-for='(msg, index) in msgs' :key='index'>
                    <div class='chat-text-sender d-flex justify-content-between align-items-center flex-row'>
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='chat-text-name'> {{ msg.sender.username }} </span>
                    </div>
                    <div class='chat-text-messages d-flex flex-column justify-content-center'>
                        <span>{{ msg.text }}</span>
                        <div class='chat-text-timestamp'>
                            {{ msg.createdAt|formatDate }}
                        </div>
                    </div>
                </div>
                <b-alert v-model="noSelectedUser" variant="danger" dismissible>
                   Please select a User.
                </b-alert>
                <b-alert v-model="emptyInput" variant="danger" dismissible>
                   Please enter some text.
                </b-alert>
            </div>
            <div class='chat-input-box'>
                <b-form-input
                id="chat"
                v-model="chatInput"
                ref="chatText"
                v-on:keyup.enter="sendChat"
                class="form-control"
                v-bind:placeholder="placeholder"
                ></b-form-input>
                <b-button @click.prevent="sendChat"> <span class='d-none d-md-flex'>Send</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <line x1="15" y1="16" x2="19" y2="12" />
                        <line x1="15" y1="8" x2="19" y2="12" />
                    </svg>
                </b-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Chat",
    data: function () {
        return {
            variant:'dark',
            isActive: false,
            ChatisActive: null,
            chatInput: "",
            connection: null,
            currentChatroom: '',
            msgs: [],
            message: '',
            time: '',
            keyword:'',
            chat:null,
            username: '',
            loggedInUser: '',
            users: [],
            sentMessage: [],
            recvMessage:[],
            chatbox: '',
            allMsgs:[],
            unreadMsg: '',
            newMsgs: [],
            chatList: [],
            isShow:true,
            participants: [],
            deletedChat: 'false',
            participant: '',
            placeholder: "Select user to chat with!",
            activeChat: '',
            noSelectedUser: 'false',
            emptyInput: 'false'
        };
    },

    created() {
        axios.get("/users").then((res) => {
            this.users = res.data;
        });

        axios.get("/users/loggedIn").then((res) => {
            this.loggedInUser = res.data;
        });

        axios.get("/chat/list").then((res) => {
            this.chatList = res.data;
            this.chatList.forEach((chat) => {
                this.participants = this.participants.concat(chat.participants);
            });
        });
    },
    computed: 
    {
        filteredUsers:function() {
            return this.users.filter(
                cust => cust.username.toLowerCase().includes(this.keyword.toLowerCase()) && cust.id !== this.loggedInUser.id
            );
        },

        computedParticipants:function() {
            return this.participants.filter(
                participant => participant.id !== this.loggedInUser.id
            );
        },
        computedMessages: function() {
            return this.msgs.filter(
               message => message.chatroom == this.chatList.id
            );
        }
    },

    mounted() {
        this.connection = new WebSocket('ws://losttaskmanager.com:5050');

        this.connection.onmessage = event => {
            const onMessage = JSON.parse(event.data);

            if (!this.activeChat) {
                this.newMsgs.push(onMessage);
            } else {
                this.msgs.push(onMessage);
                this.$nextTick(() => {
                    this.scrollDown();
                });
            }
        },

        this.connection.readyState;
    },

    methods: { 
        sendChat() {
            const msgInfo = {
                recv: this.activeChat,
                text: this.chatInput  
            };
            if (!this.activeChat) {
                this.noSelectedUser = true;
                this.$nextTick(() => {
                    this.scrollDown();
                });
            } else if (!this.chatInput.trim()) {
                this.emptyInput = true;
                this.$nextTick(() => {
                    this.scrollDown();
                });
            } else {
                this.emptyInput = false;
                this.connection.send(JSON.stringify(msgInfo)); 
                this.chatInput = '';
            }
        },

        closeUserDropdown() {
            this.isActive = !this.isActive;
        },

        openUserDropdown() {
            this.isActive = !this.isActive;
        },

        closeDeleteModal() {
            this.deletedChat = false;
            this.$root.$emit('bv::hide::modal', 'deleteModal', '#btnShow');
        },

        openDeleteModal() {
            if (this.currentChatroom) {
                this.$root.$emit('bv::show::modal', 'deleteModal', '#btnShow');
            } else {
                this.noSelectedUser = true;
            }
        },

        deleteChat() {
            axios.delete(`/chat/list/${this.currentChatroom}/deleteChat`, {
               data: {id: this.currentChatroom}
            })
            .then(() => {
                this.deletedChat = true;
                this.participants.splice(this.participants.findIndex(n => n.id === this.activeChat), 1);
                this.msgs = '';
                this.placeholder = `Start new Chat`;
                this.activeChat = '';
            })
        },

        resetDeleteModal() {
            this.deletedChat = false;
        },

        addUser(userId) {
            this.$root.$emit('bv::toggle::collapse', 'sidebar-chat-toggle');
            this.isActive = false;
            this.$nextTick(() => {
                this.$refs['chatText'].focus();
            });

            const activeUser = this.users.find(user => user.id == userId);

            if (activeUser) {
                this.placeholder = `Start Chat with ${activeUser.username}`;
                this.participants.forEach((participant) => {
                    if (activeUser.id == participant.id) {
                        this.openChat(participant.id);
                    } else if  (activeUser.id != participant.id && this.msgs.length > 0) {
                        this.placeholder = `Start Chat with ${activeUser.username}`;
                        this.msgs = '';
                    }
                });

                this.activeChat = activeUser.id;
            }
        },

        openChat(participantId) {
            this.newMsgs = '';
            this.ChatisActive = participantId;
            axios.get(`/chat/list/${participantId}`)
            .then(function ( res ){
                this.msgs = res.data[0].messages;
                this.currentChatroom = res.data[0].messages[0].chatroom;
                this.$nextTick(() => {
                    this.newMsgs = '';
                    this.scrollDown();
                });
            }.bind(this));

            this.$root.$emit('bv::toggle::collapse', 'sidebar-chat-toggle');
            this.$nextTick(() => {
                this.$refs['chatText'].focus(); 
                this.noSelectedUser = false;
            });

            this.users.forEach((user) => {
                if (participantId == user.id) {
                    this.placeholder = `Hello ${user.username}...`;
                    return;
                }
            });
            this.activeChat = participantId;
        },

        scrollDown() {
            const chatWrapper = document.getElementById('chat-wrapper');
            chatWrapper.scrollTop = chatWrapper.scrollHeight;
        }
    }
};
</script>
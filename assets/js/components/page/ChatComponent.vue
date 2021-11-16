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
                            <b-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret  @click.prevent="addUser">
                                <template #button-content>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 11h6m-3 -3v6" />
                                    </svg>
                                </template>
                                <b-dropdown-item href="#">Action</b-dropdown-item>
                                <b-dropdown-item href="#">Another action</b-dropdown-item>
                                <b-dropdown-item href="#">Something else here...</b-dropdown-item>
                            </b-dropdown>
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
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>waniel.dolf</span>
                    </div>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>Xeejia</span>
                    </div>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>Joeels Project</span>
                    </div>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'> Tuc0ws Project</span>
                    </div>
                </div>
            </b-sidebar>
        </div>
        <div class='col-md-4 d-none d-md-block'>
            <div class='chat-user--panel'>
                <div class='chat-user--headline d-flex justify-content-between'>
                    <headline-component title="Chat" classes='h1'></headline-component>
                        <div class='chat-user--icon'>
                            <b-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret>
                                <template #button-content>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 11h6m-3 -3v6" />
                                    </svg>
                                </template>
                                <b-dropdown-item v-for="user in this.users" :key="user.id"  v-on:click="addUser(user.id)">{{user.username}}</b-dropdown-item>
                            </b-dropdown>
                        </div>
                </div>
                <div class='chat-user--list'>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>waniel.dolf</span>
                    </div>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>Xeejia</span>
                    </div>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'>Joeels Project</span>
                    </div>
                    <div class='chat-user--item' v-on:click="openItem()">
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='user-name'> Tuc0ws Project</span>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-8 pl-md-3 chat-message--box'>
            <div class='chat-wrapper'>
                <div class='text-white chat-text-box' v-for='(msg, index) in msgs' :key='index'>
                    <div class='chat-text-sender d-flex justify-content-between align-items-center flex-row'>
                        <span class='user-icon'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="9" y1="10" x2="9.01" y2="10" />
                                <line x1="15" y1="10" x2="15.01" y2="10" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                        </span> 
                        <span class='chat-text-name'> {{ msg.chatUsername }} </span>
                    </div>
                    <div class='chat-text-messages d-flex flex-column justify-content-center'>
                        <span>{{ msg.chatText }}</span>
                        <div class='chat-text-timestamp'>
                            {{ msg.chatDate | formatDate }}
                        </div>
                    </div>

                </div>
            </div>
            <div class='chat-input-box'>
                <b-form-input
                id="chat"
                v-model="chatInput"
                v-on:keyup.enter="sendChat"
                class="form-control"
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
            chatInput: "",
            connection: null,
            msgs: [],
            message: '',
            time: '',
            username: '',
            users: null
            
        };
    },

    created() {
        axios.get("/users").then((res) => {
            this.users = res.data;
        });
    },

    mounted() {
        this.connection = new WebSocket('ws://localhost:8080');

        this.connection.onopen = function(e) {
            console.log("Connection established!");
            console.log(e.data);
        };

        this.connection.onclose = function(e) {
            console.log("Connection closed");
        }

        this.connection.onmessage = event => {
            const onMessage = JSON.parse(event.data);
            this.msgs.push(onMessage);
       
        }

        this.connection.readyState;
    },

    methods: { 
        sendChat() {
            this.connection.send(this.chatInput); 
            this.chatInput = '';
        },

        addUser() {

        }
    }
};
</script>
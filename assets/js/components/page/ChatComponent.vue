<template>
    <div class='row no-gutters chat-user--wrapper align-items-start'>
        <div class='col-md-4'>
            <div class='chat-user--panel'>
                <div class='chat-user--headline d-flex justify-content-between'>
                    <headline-component title="Chat" classes='h1'></headline-component>
                    <div class='chat-user--icon'>
                        <b-button variant="link"  @click.prevent="addUser">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 11h6m-3 -3v6" />
                            </svg>
                        </b-button>        
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
        <div class='col-md-8 pl-3'>
            <div class='chat-wrapper'>
                <div class='text-white chat-text-box' v-for='(msg, index) in msgs' :key='index'>
                    <div class='chat-text-sender'>
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
                    <div class='chat-text-messages'>
                        <span>{{ msg.chatText }}</span>
                        <div class='chat-text-timestamp'>
                            {{ msg.chatDate }}
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
                <b-button @click.prevent="sendChat"> Send 
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
            chatInput: "",
            connection: null,
            msgs: [],
            message: '',
            time: '',
            username: '',
            
        };
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
            this.msgs.push({
                chatText : this.chatInput,
                
            });

            console.log('send Chat', this.msgs);

            this.connection.send(this.chatInput); 
        
            //this.connection.send(this.chatInput);
            //console.log('sendChat', this.msgs);
            //this.msgs.push(this.chatInput);
            this.chatInput = '';
        }
    }
};
</script>
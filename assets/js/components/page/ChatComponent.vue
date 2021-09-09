<template>
    <div>
        <div class='col-12'>
            <headline-component title="Chat" classes='h2'></headline-component>
            <b-form-input
              id="chat"
              v-model="chatInput"
              v-on:keyup.enter="sendChat"
              class="form-control"
            ></b-form-input>
            <div class='text-white' v-for='(msg, index) in msgs' :key='index'>
                {{ msg }}
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

        };
    },

    mounted() {
        this.connection = new WebSocket('ws://localhost:8080');

        this.connection.onopen = function(e) {
            console.log("Connection established!");
            console.log(this.connection);
        };

        this.connection.onmessage = event => {
            this.msgs.push(event.data);
        }

        this.connection.readyState;
    },

    methods: { 
        sendChat() {
            this.connection.send(this.chatInput);
            this.msgs.push(this.chatInput);
            this.chatInput = '';
        }
    }
};
</script>
<template>
  <div class="col-md-12">
    <div>
      <div class="row">
        <sidebar></sidebar>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex">
          <div class="notes-list--panel col-md-4">
            <div class="notes-list--headline d-flex justify-content-between">
              <headline-component title="All Ideas"></headline-component>
              <div class="notes--icons">
                <b-button variant="link"  @click.prevent="focusEditor">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-file"
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
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path
                      d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"
                    />
                  </svg>
                </b-button>
                <b-button variant="link"  @click.prevent="deleteNote">
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
                </b-button>
              </div>
            </div>
            <div class="notes-list-items" v-if="notes">
              <div
                class="notes-list-item"
                v-for="note in this.notes"
                :key="note.id"
                v-html="$options.filters.truncate(note.text, 50, '..')"
                v-on:click="openItem(note.id)"
              ></div>
            </div>
          </div>
          <div class="information-panel col-md-8">
            <div class="d-flex">
              <vue-editor v-model="content" ref='editor' @text-change='editNote()' />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "Notes",
  data: function() {
    return {
      loading: false,
      error: null,
      content: null,
      notes: null,
      currentNoteId: null,
      timeout: null
    };
  },

  created() {
    axios.get("/notes/list").then((res) => {
      this.notes = res.data;
    });
  },

  computed: {

  },
  
  methods: {
    editNote() {
      clearTimeout(this.timeout);

      this.timeout = setTimeout(() => {
        if (this.currentNoteId) {
          axios.patch(`/notes/${this.currentNoteId}/editNote`, {
          text: this.content
          });
          this.notes.forEach((note) => {
            if (this.currentNoteId == note.id) {
              note.text = this.content;
            }
          });
        } else {
          axios.post("/notes/createNote", {
            text: this.content,
          })
          .then((res) => {
            this.notes.push(res.data);
            this.currentNoteId = res.data.id;
        });
        }
      },500);
    },

    deleteNote() {
    	axios.delete(`/notes/${this.currentNoteId}/deleteNote`, {
        data: {id: this.currentNoteId}
      })
      .then(() => {
        this.notes.splice(this.notes.findIndex(n => n.id === this.currentNoteId), 1);
        this.$refs.editor.quill.deleteText(0,this.content.length);
      })
    },

    focusEditor() {
      if (this.content) { 
         this.$refs.editor.quill.deleteText(0,this.content.length);
      }
      this.$refs.editor.quill.focus();
      this.content = "";
      this.currentNoteId = "";
    },

    openItem(noteId) {
      this.notes.forEach((note) => {
        if (noteId == note.id) {
          this.content = note.text;
          this.currentNoteId = note.id;
          return;
        }
      });
    },
  },
};
</script>

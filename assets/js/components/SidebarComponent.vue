<template>
  <div class='sidebar-component'>
    <b-button v-b-toggle.sidebar-no-header variant='link'>
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-right" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <line x1="4" y1="6" x2="20" y2="6" />
            <line x1="10" y1="12" x2="20" y2="12" />
            <line x1="6" y1="18" x2="20" y2="18" />
        </svg>
    </b-button>
    <b-sidebar id="sidebar-no-header" aria-labelledby="sidebar-no-header-title"  bg-variant="dark" :backdrop-variant="variant" shadow backdrop>
      <template #default="{ hide }">
        <div class="p-3">
          <nav class="mb-3">
            <b-nav vertical>
              <b-nav-item @click="hide"><b-icon-grid></b-icon-grid> Dashboard</b-nav-item>
              <b-nav-item href="#link-1" @click="hide" active><b-icon-folder></b-icon-folder> Projects</b-nav-item>
              <b-nav-item href="#link-2" @click="hide"><b-icon-chat-dots></b-icon-chat-dots> Chat</b-nav-item>
              <b-nav-item href="#link-2" @click="hide"><b-icon-file-earmark-check></b-icon-file-earmark-check> Approvo</b-nav-item>
              <b-nav-item href="#link-2" @click="hide"><b-icon-file-text></b-icon-file-text> Notes</b-nav-item>
            </b-nav>
          </nav>
        </div>
      </template>
    </b-sidebar>
  </div>
</template>
<script>
export default {
    props: {
    },
    data: function() {
        return {
            variant:'transparent'
        }
    }
}
</script>
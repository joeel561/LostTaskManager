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
    <b-sidebar id="sidebar-no-header" aria-labelledby="sidebar-no-header-title"  text-variant="light" bg-variant="dark" :backdrop-variant="variant" shadow backdrop>
      <div class="p-3">
        <nav class="mb-3">
            <ul class='nav flex-column'>
              <li class='nav-item'>
                <router-link to="/home"><b-icon-grid></b-icon-grid> Dashboard</router-link>
              </li>
              <li class='nav-item'>
                <router-link to="/projects"><b-icon-folder></b-icon-folder> Projects</router-link>
              </li>
              <li class='nav-item'>
                <router-link to="/chat"><b-icon-chat-dots></b-icon-chat-dots> Chat</router-link>
              </li>
              <li class='nav-item'>
                <router-link to="/notes"><b-icon-file-text></b-icon-file-text> Notes</router-link>
              </li>
            </ul>
        </nav>
      </div>
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
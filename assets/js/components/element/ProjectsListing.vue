<template>
    <div class="projects-row">
        <b-row>
            <b-col
            cols="6"
            class='col-sm-4 ni-col-2'
            v-for="project in computedProj"
            :key="project.id"
            >
            <b-button :to="{ name: 'project', params: {id: project.id} }" class='project-column'>
                <div>
                    <h3>{{ project.name | truncate(2, "") }}</h3>
                    <span>{{ project.name | truncate(20, "..") }}</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-arrow-narrow-right"
                        width="44"
                        height="44"
                        viewBox="0 0 24 24"
                        stroke-width="1"
                        stroke="#2c3e50"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <line x1="15" y1="16" x2="19" y2="12" />
                        <line x1="15" y1="8" x2="19" y2="12" />
                    </svg>
                </div>
            </b-button>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    export default ({
        name:"ProjectsListing",

        props: {
            maxLimit: Number
        },
        data: function () {
            return {
                projects: []
            };
        },

        created() {
            axios.get("/projects/list").then((res) => {
                this.projects = res.data;
            });
        },

        computed: {
            computedProj() {
                 return this.maxLimit ? this.projects.slice(0,this.maxLimit) : this.projects
            }
        }
    });
</script>

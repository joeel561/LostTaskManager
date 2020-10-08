<template> 
    <div class='headline-wrapper'>
        <h1>{{ title }}</h1>
    </div>
</template>
<script>
export default {
    props: {
        title: String
    },
    data: function() {
        return {
        }
    }
}
</script>
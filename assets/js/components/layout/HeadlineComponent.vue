<template> 
    <div class='headline-wrapper'>
        <p :class='classes'>{{ title }}</p>
    </div>
</template>
<script>
export default {
    props: {
        title: String,
        classes: String
    },
    data: function() {
        return {
        }
    }
}
</script>
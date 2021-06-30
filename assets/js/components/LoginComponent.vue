<template>
    <div class="form-group col-md-12">
        <input :type="type" :id="id" class="form-control" :name="'_'+ id" value="" autocomplete="off" required />
        <label :for="id">{{ title }}</label>
    </div>
</template>
<script>
export default {
    props: {
        title: String,
        id: String,
        type: String
    },
    data: function() {
        return {
        }
    }
}
</script>
<template>
    <span>
        <img :src="thumbUrl(field.value || 1)" alt="" class="uc-thumb-img" style="max-width: 256px"/>
    </span>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>

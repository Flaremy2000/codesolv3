<template>
    <div class="container">
        <cardnews />
    </div>
</template>

<script>
import Cardnews from './components/Newscomponents/Cardnew.vue'
export default {
    name: 'News',
    components: { Cardnews },
}
</script>

<style scoped>
.container {
    margin-top: 66px;
}
</style>

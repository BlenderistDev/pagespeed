<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
            :can-cancel="false" 
            :is-full-page="fullPage"
            :loader="loader">
        </loading>
    </div>
</template>
 
<script>
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.css';
  
  export default {
    data() {
      return {
        isLoading: false,
        fullPage: true,
        loader: 'dots',
      }
    },
    components: {
      Loading
    },
    methods: {
      show: function() {
        this.isLoading = true;
      },
      hide: function() {
        this.isLoading = false;
      },
    }
  }
</script> 
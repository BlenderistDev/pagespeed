<template lang="pug">
  .card
    .card-header Добавить Замер
    .card-body
      .form-group
        input(v-model="domain" class="form-control" placeholder="Domain")
        button(v-on:click="addMeasure()" class="btn btn-primary") Отправить
        PreLoader(ref="preloader")
</template>

<script>
import { mapActions } from 'vuex';
import PreLoader from './PreLoader.vue';

export default {
  components: {
    PreLoader,
  },
  data: () => {
    return {
      domain: ''
    }
  },
  methods: {
    ...mapActions([
      'fetchMeasurements'
    ]),
    addMeasure: function() {
      this.$refs.preloader.show();
      axios.post('/api/measurements/store', {
        domain: this.domain,
      }).then(response => {
         this.$refs.preloader.hide();
        this.fetchMeasurements();
      });
    },
  }
}
</script>

<style scoped>
  .card {
    width: 100%;
  }
</style>
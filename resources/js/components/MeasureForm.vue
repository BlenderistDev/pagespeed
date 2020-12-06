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
    addMeasure: function() {
      this.$refs.preloader.show();
        axios.post('/api/measurements/store', {
          domain: this.domain,
        }).then(response => {
          this.$refs.preloader.hide();
          this.$emit('new-measure-added');
        });
    },
  }
}
</script>

<style scoped>
  .card {
    width: 100%;
    /* padding: 20px; */
  }
</style>
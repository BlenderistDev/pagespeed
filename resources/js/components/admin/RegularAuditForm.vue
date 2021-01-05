<template lang="pug">
  form(class="was-uvalidated")
    button(class="btn btn-outline-primary" @click="$emit('edit-ended')") Назад
    .form-group.row(v-for="(fieldName, fieldKey) in fields" :key="fieldKey")
      label(class='col-sm-2') {{fieldName}}
      input(:class="getFieldClass(fieldKey)" v-model="audit[fieldKey]")
      div(v-if="errors[fieldKey]" class="invalid-feedback") {{ errors[fieldKey].join('') }}
    button(class="btn btn-primary" @click="sendRegularAudit") Отправить

</template>

<script>
export default {
  props: {
    audit: Object,
  },
  data: function() {
    return {
      showForm: false,
      fields: {
        url: "Ссылка",
        minute: "Минута",
        hour: "Час",
        month_day: "Число месяца",
        month: "Месяц",
        week_day: "День недели",
        email: "Email для отправки результатов",
      },
      errors: {},
      formValidated: false,
    }
  },
  methods: {
    sendRegularAudit: function() {
      axios.put('/api/regular-audits', this.audit).then(response => {
        if (response.statusText === 'OK') {
          this.showForm = false;
          this.errors = {};
          this.formValidated = true;
          setTimeout(() => this.$emit('item-created'), 1000);
        }
      }).catch((error) => {
        this.errors = error.response.data.errors;
      })
    },
    getFieldClass: function(fieldKey) {
      let fieldClass = 'col-sm-8 form-control ';
      if (this.errors[fieldKey]) {
        fieldClass += "is-invalid";
      } else {
        if (this.formValidated) {
          fieldClass += 'is-valid';
        }
      }
      return fieldClass;
    },
  }
}
</script>

<style>
  .btn-outline-primary {
    margin-bottom: 20px;
  }
</style>
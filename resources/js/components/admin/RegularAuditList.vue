<template lang="pug">
  div
    RegularAuditForm(:audit="currentAudit" 
      v-if="showForm"
      v-on:item-created="updateList()" 
      v-on:edit-started="editStarted()"
      v-on:edit-ended="editEnded()"
    )
    div(v-else)
      button(v-on:click="showEditForm({})" class="btn btn-primary") Создать
      table(class="table")
        thead
          th(v-for="(field) in fields") {{ field }}
        tbody
          tr(v-for="audit in regularAuditList" v-bind:key="audit.id")
            td(v-for="(field, fieldKey) in fields") {{ audit[fieldKey] }}
            td
              button(v-on:click="showEditForm(audit)" class="btn btn-primary") Редактировать

</template>

<script>
import RegularAuditForm from './RegularAuditForm.vue';

export default {
  components: {
    RegularAuditForm,
  },
  data: function() {
    return {
      regularAuditList: [],
      fields: {
        url: "Ссылка",
        minute: "Минута",
        hour: "Час",
        month_day: "Число месяца",
        month: "Месяц",
        week_day: "День недели",
      },
      showForm: false,
      currentAudit: {},
    }
  },
  created: function() {
    this.updateList();
  },
  methods: {
    editEnded: function() {
      this.showForm = false;
      this.audit = {};
    },
    updateList: function() {
      axios.get('/api/regular-audits').then((response) => {
        this.regularAuditList = response.data;
        this.editEnded();
      });
    },
    showEditForm: function(audit) {
      this.currentAudit = audit;
      this.showForm = true;
    }
  }
}
</script>

<style>

</style>
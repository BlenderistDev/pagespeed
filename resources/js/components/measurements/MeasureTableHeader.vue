<template lang="pug">
thead
  tr
    th(scope="col")
      FilterForm(field="id") id
      SortButton(columnName="id") id
    th(scope="col")
      FilterForm(field="domain")
      SortButton(columnName="domain") domain
    th(scope="col")
      FilterForm(field="comment")
      SortButton(columnName="comment") comment
    th(scope="col")
      DateFilter(field="created_at")
      SortButton(columnName="created_at") created_at

    template(v-for="(serviceAudits, serviceKey) in audits")
      template(v-for="audit in serviceAudits")
        transition(name="slide-fade")
          th(v-show="showColumns[serviceKey].includes(audit.name)" scope="col" :title="audit.description")
            SortButtonAudit(
              :auditId="audit.id"
              :service="serviceKey"
            ) {{ audit.title }}
</template>

<script>
import SortButton from './SortButton.vue';
import SortButtonAudit from './SortButtonAudit.vue';
import FilterForm from './FilterForm.vue';
import DateFilter from './DateFilter.vue';
import { mapGetters, mapState } from 'vuex';

export default {
  components: {
    SortButton,
    SortButtonAudit,
    FilterForm,
    DateFilter,
  },
  computed: {
    ...mapState([
      'audits',
      'showColumns',
    ]),
  },
}
</script>

<style scoped>
  .slide-fade-enter-active, .slide-fade-leave-active {
    transition: all .3s ease;
  }
  .slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
  }
</style>

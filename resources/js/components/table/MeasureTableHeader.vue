<template lang="pug">
  thead
    tr
      th(scope="col")
        FilterForm(field="domain")
        SortButton(columnName="domain") domain
      th(scope="col") 
        FilterForm(field="comment")
        SortButton(columnName="comment") comment
      th(scope="col")
        SortButton(columnName="created_at") created_at

      template(v-for="(serviceAudits, serviceKey) in audits")
        template(v-for="audit in serviceAudits")
          th(v-show="showColumns[serviceKey].includes(audit.name)" scope="col" :title="audit.description")
            SortButtonAudit(
              :auditId="audit.id"
              :service="serviceKey"
            ) {{ audit.name }}
</template>

<script>
import SortButton from './SortButton.vue';
import SortButtonAudit from './SortButtonAudit.vue';
import FilterForm from './FilterForm.vue';
import { mapGetters, mapState } from 'vuex';

export default {
  components: {
    SortButton,
    SortButtonAudit,
    FilterForm,
  },
  computed: {
    ...mapState([
      'audits',
      'showColumns',
    ]),
  },
}
</script>
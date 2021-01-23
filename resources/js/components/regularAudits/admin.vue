<template lang="pug">
  div
    RegularAuditList(@edit="editRegularAudit")
</template>

<script>

import RegularAuditForm from './RegularAuditForm.vue';
import RegularAuditList from './RegularAuditList.vue';

export default {
  data: function() {
    return {
      isEdit: false,
      auditId: null,
    }
  },
  components: {
    RegularAuditForm,
    RegularAuditList,
  },
  methods: {
    editRegularAudit: function(auditId) {
      console.log(auditId);
      this.isEdit = true;
      this.auditId = auditId;
    },
  }
}
</script>
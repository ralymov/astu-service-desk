<template>
  <reference-table-list
      entity="programs"
      ref="softwareList"
      :additionalFields="additionalFields"
      nameFieldLabel="Название"
      :requestFields="['name']"
      paginate
  >


  </reference-table-list>
</template>

<script>
  import ReferenceTableList from 'common/ReferenceTableList'

  export default {
    components: {
      ReferenceTableList
    },
    data() {
      return {
        additionalFields: []
      }
    },
  }
</script>


<template>
  <reference-table-list entity="ticketTypes"></reference-table-list>
</template>

<script>
  import ReferenceTableList from 'components/common/ReferenceTableList'

  export default {
    name: "TicketTypes",
    components: {
      ReferenceTableList
    },
  }
</script>

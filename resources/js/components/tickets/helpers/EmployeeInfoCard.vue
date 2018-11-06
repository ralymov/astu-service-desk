<template>
  <b-card header-tag="header"
          footer-tag="footer"
          :title="employee.name"
          class="employee-info-card">

    <h4 slot="header" class="mb-0">Информация о сотруднике</h4>

    <p class="card-text">
      Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>

  </b-card>
</template>

<script>

  export default {
    name: "EmployeeInfoCard",
    props: {
      employee: {
        type: Object,
        default: () => {
        },
      }
    },
    data() {
      return {}
    },
    mounted() {

    },
    methods: {}
  }
</script>

<style scoped>
  .employee-info-card {
    width: 200px;
  }
</style>
